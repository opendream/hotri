<?php

include_once('PDF.php');

define('UFPDF_FONTPATH', '../font/');
define('FPDF_VERSION', 1.53);

class UFPDF extends PDF
{
  function UFPDF($format, $orientation) {
    PDF::PDF($format, $orientation);
  }

  /**
  * Public Methods ------------------------------------------------------------
  */
  function text($p, $txt) {
    // Output a string
    $bbox = $this->currentFont['desc']['FontBBox']; // '[-659 -589 1090 1288]'
    $bbox = split(' ', $bbox); // split each member and get the last
    $bbox = substr($bbox[3], 0, -1); // strip ']' from '1288]'
    $y_base = $bbox * $this->fontSize / 1000.0;
    $s = sprintf('BT %.2f %.2f Td %s Tj ET',
                 $p['x'], $p['y'] - $y_base, $this->_escapetext($txt));

    if ($this->ColorFlag)
      $s = 'q '.$this->TextColor.' '.$s.' Q';

    $this->_out($s);
  }

  function textDim($s) {
    //Get width of a string in the current font
    $s = (string)$s;
    $codepoints = $this->utf8_to_codepoints($s);
    $cw =& $this->currentFont['cw'];
    $w = 0;
    foreach ($codepoints as $cp)
      $w += $cw[$cp];

    # array(x-min, y-min, x-max, y-max) -- LOWER-LEFT ORIGIN
    $bbox = $this->currentFont['desc']['FontBBox']; // '[-659 -589 1090 1288]'
    $bbox = split(' ', $bbox); // split each member with space
    $bbox = array(substr($bbox[0], 1), $bbox[1], $bbox[2], substr($bbox[3], 0, -1));
    $dim = array();
    $dim['x'] = $w * $this->fontSize / 1000.0;
    $dim['y'] = ($bbox[3] - $bbox[1]) * $this->fontSize / 1000.0;
    $dim['x-base'] = (-1 * $bbox[0]) * $this->fontSize / 1000.0;
    $dim['y-base'] = $bbox[3] * $this->fontSize / 1000.0;
    return $dim;
  }

  /**
  * Protected Methods ---------------------------------------------------------
  */
  function _loadFont($name) {
    //Add a TrueType or Type1 font
    $file = UFPDF_FONTPATH.$name.'.php';
    include($file);
    if ($file) {
      if ($type == 'TrueTypeUnicode')
        $this->FontFiles[$file] = array('length1'=>$originalsize);
      else
        $this->FontFiles[$file] = array('length1'=>$size1, 'length2'=>$size2);
    }

    $i = count($this->fonts) + 1;
    $this->fonts[$name] = array('i'=>$i, 'type'=>$type, 'name'=>$name, 'desc'=>$desc, 'up'=>$up, 'ut'=>$ut, 'cw'=>$cw, 'file'=>$file, 'ctg'=>$ctg);
  }

  function _putfonts() {
    $nf = $this->n;
    foreach ($this->diffs as $diff) {
      //Encodings
      $this->_newobj();
      $this->_out('<</Type /Encoding /BaseEncoding /WinAnsiEncoding /Differences ['.$diff.']>>');
      $this->_out('endobj');
    }

    $mqr = get_magic_quotes_runtime();
    set_magic_quotes_runtime(0);

    foreach ($this->FontFiles as $file=>$info) {
      //Font file embedding
      $this->_newobj();
      $this->FontFiles[$file]['n'] = $this->n;
      $font = '';

      $f = fopen(UFPDF_FONTPATH.$file, 'rb', 1);
      if (!$f)
        $this->Error('Font file not found');

      while (!feof($f))
        $font .= fread($f, 8192);

      fclose($f);

      $compressed = (substr($file, -2) == '.z');
      if (!$compressed && isset($info['length2'])) {
        $header = (ord($font{0}) == 128);
        if ($header) {
          //Strip first binary header
          $font = substr($font, 6);
        }

        if ($header && ord($font{$info['length1']}) == 128) {
          //Strip second binary header
          $font = substr($font,0,$info['length1']).substr($font,$info['length1']+6);
        }
      }

      $this->_out('<</Length '.strlen($font));

      if ($compressed)
        $this->_out('/Filter /FlateDecode');

      $this->_out('/Length1 '.$info['length1']);

      if (isset($info['length2']))
        $this->_out('/Length2 '.$info['length2'].' /Length3 0');

      $this->_out('>>');
      $this->_putstream($font);
      $this->_out('endobj');
    }

    set_magic_quotes_runtime($mqr);

    foreach ($this->fonts as $name => $font) {
      //Font objects
      $this->fonts[$name]['n'] = $this->n + 1;
      $type = $font['type'];
      if ($type == 'Core') {
        //Standard font
        $this->_newobj();
        $this->_out('<</Type /Font');
        $this->_out('/BaseFont /'.$name);
        $this->_out('/Subtype /Type1');

        if ($name != 'Symbol' && $name != 'ZapfDingbats')
          $this->_out('/Encoding /WinAnsiEncoding');

        $this->_out('>>');
        $this->_out('endobj');
      }
      elseif ($type == 'Type1' || $type == 'TrueType') {
        //Additional Type1 or TrueType font
        $this->_newobj();
        $this->_out('<</Type /Font');
        $this->_out('/BaseFont /'.$name);
        $this->_out('/Subtype /'.$type);
        $this->_out('/FirstChar 32 /LastChar 255');
        $this->_out('/Widths '.($this->n+1).' 0 R');
        $this->_out('/FontDescriptor '.($this->n+2).' 0 R');
        if ($font['enc']) {
          if (isset($font['diff']))
            $this->_out('/Encoding '.($nf+$font['diff']).' 0 R');
          else
            $this->_out('/Encoding /WinAnsiEncoding');
        }
        $this->_out('>>');
        $this->_out('endobj');
        //Widths
        $this->_newobj();
        $cw = &$font['cw'];
        $s = '[';
        for ($i=32; $i<=255; $i++)
          $s.=$cw[chr($i)].' ';
        $this->_out($s.']');
        $this->_out('endobj');
        //Descriptor
        $this->_newobj();
        $s='<</Type /FontDescriptor /FontName /'.$name;
        foreach ($font['desc'] as $k=>$v)
          $s.=' /'.$k.' '.$v;
        $file=$font['file'];
        if ($file)
          $s.=' /FontFile'.($type=='Type1' ? '' : '2').' '.$this->FontFiles[$file]['n'].' 0 R';
        $this->_out($s.'>>');
        $this->_out('endobj');
      }
      else {
        //Allow for additional types
        $mtd = '_put'.strtolower($type);
        if (!method_exists($this, $mtd))
          $this->Error('Unsupported font type: '.$type);
        $this->$mtd($font);
      }
    }
  }

  function _puttruetypeunicode($font) {
    //Type0 Font
    $this->_newobj();
    $this->_out('<</Type /Font');
    $this->_out('/Subtype /Type0');
    $this->_out('/BaseFont /'. $font['name'] .'-UCS');
    $this->_out('/Encoding /Identity-H');
    $this->_out('/DescendantFonts ['. ($this->n + 1) .' 0 R]');
    $this->_out('>>');
    $this->_out('endobj');

    //CIDFont
    $this->_newobj();
    $this->_out('<</Type /Font');
    $this->_out('/Subtype /CIDFontType2');
    $this->_out('/BaseFont /'. $font['name']);
    $this->_out('/CIDSystemInfo <</Registry (Adobe) /Ordering (UCS) /Supplement 0>>');
    $this->_out('/FontDescriptor '. ($this->n + 1) .' 0 R');

    $widths = '';
    foreach ($font['cw'] as $i => $w) {
      $widths .= $i .' ['. $w.'] ';
    }

    $this->_out('/W ['. $widths .']');
    $this->_out('/CIDToGIDMap '. ($this->n + 2) .' 0 R');
    $this->_out('>>');
    $this->_out('endobj');

    //Font descriptor
    $this->_newobj();
    $this->_out('<</Type /FontDescriptor');
    $this->_out('/FontName /'.$font['name']);

    $s = '';
    foreach ($font['desc'] as $k => $v) {
      $s .= ' /'. $k .' '. $v;
    }

    if ($font['file']) {
      $s .= ' /FontFile2 '. $this->FontFiles[$font['file']]['n'] .' 0 R';
    }

    $this->_out($s);
    $this->_out('>>');
    $this->_out('endobj');

    //Embed CIDToGIDMap
    $this->_newobj();

    if (defined('UFPDF_FONTPATH'))
      $file = UFPDF_FONTPATH.$font['ctg'];
    else
      $file = $font['ctg'];

    $size = filesize($file);
    if (!$size)
      $this->Error('Font file not found');

    $this->_out('<</Length '.$size);

    if (substr($file,-2) == '.z')
      $this->_out('/Filter /FlateDecode');

    $this->_out('>>');
    $f = fopen($file,'rb');
    $this->_putstream(fread($f,$size));
    fclose($f);
    $this->_out('endobj');
  }

  function _escapetext($s) {
    //Convert to UTF-16BE
    $s = $this->utf8_to_utf16be($s, false);
    //Escape necessary characters
    return '('. strtr($s, array(')' => '\\)', '(' => '\\(', '\\' => '\\\\')) .')';
  }

  // UTF-8 to UTF-16BE conversion.
  // Correctly handles all illegal UTF-8 sequences.
  function utf8_to_utf16be(&$txt, $bom = true) {
    $l = strlen($txt);
    $out = $bom ? "\xFE\xFF" : '';
    for ($i = 0; $i < $l; ++$i) {
      $c = ord($txt{$i});
      // ASCII
      if ($c < 0x80) {
        $out .= "\x00". $txt{$i};
      }
      // Lost continuation byte
      else if ($c < 0xC0) {
        $out .= "\xFF\xFD";
        continue;
      }
      // Multibyte sequence leading byte
      else {
        if ($c < 0xE0) {
          $s = 2;
        }
        else if ($c < 0xF0) {
          $s = 3;
        }
        else if ($c < 0xF8) {
          $s = 4;
        }
        // 5/6 byte sequences not possible for Unicode.
        else {
          $out .= "\xFF\xFD";
          while (ord($txt{$i + 1}) >= 0x80 && ord($txt{$i + 1}) < 0xC0) { ++$i; }
          continue;
        }
        
        $q = array($c);
        // Fetch rest of sequence
        while (ord($txt{$i + 1}) >= 0x80 && ord($txt{$i + 1}) < 0xC0) { ++$i; $q[] = ord($txt{$i}); }
        
        // Check length
        if (count($q) != $s) {
          $out .= "\xFF\xFD";        
          continue;
        }
        
        switch ($s) {
          case 2:
            $cp = (($q[0] ^ 0xC0) << 6) | ($q[1] ^ 0x80);
            // Overlong sequence
            if ($cp < 0x80) {
              $out .= "\xFF\xFD";        
            }
            else {
              $out .= chr($cp >> 8);
              $out .= chr($cp & 0xFF);
            }
            continue;

          case 3:
            $cp = (($q[0] ^ 0xE0) << 12) | (($q[1] ^ 0x80) << 6) | ($q[2] ^ 0x80);
            // Overlong sequence
            if ($cp < 0x800) {
              $out .= "\xFF\xFD";        
            }
            // Check for UTF-8 encoded surrogates (caused by a bad UTF-8 encoder)
            else if ($c > 0xD800 && $c < 0xDFFF) {
              $out .= "\xFF\xFD";
            }
            else {
              $out .= chr($cp >> 8);
              $out .= chr($cp & 0xFF);
            }
            continue;

          case 4:
            $cp = (($q[0] ^ 0xF0) << 18) | (($q[1] ^ 0x80) << 12) | (($q[2] ^ 0x80) << 6) | ($q[3] ^ 0x80);
            // Overlong sequence
            if ($cp < 0x10000) {
              $out .= "\xFF\xFD";
            }
            // Outside of the Unicode range
            else if ($cp >= 0x10FFFF) {
              $out .= "\xFF\xFD";            
            }
            else {
              // Use surrogates
              $cp -= 0x10000;
              $s1 = 0xD800 | ($cp >> 10);
              $s2 = 0xDC00 | ($cp & 0x3FF);
              
              $out .= chr($s1 >> 8);
              $out .= chr($s1 & 0xFF);
              $out .= chr($s2 >> 8);
              $out .= chr($s2 & 0xFF);
            }
            continue;
        }
      }
    }
    return $out;
  }

  // UTF-8 to codepoint array conversion.
  // Correctly handles all illegal UTF-8 sequences.
  function utf8_to_codepoints(&$txt) {
    $l = strlen($txt);
    $out = array();
    for ($i = 0; $i < $l; ++$i) {
      $c = ord($txt{$i});
      // ASCII
      if ($c < 0x80) {
        $out[] = ord($txt{$i});
      }
      // Lost continuation byte
      else if ($c < 0xC0) {
        $out[] = 0xFFFD;
        continue;
      }
      // Multibyte sequence leading byte
      else {
        if ($c < 0xE0) {
          $s = 2;
        }
        else if ($c < 0xF0) {
          $s = 3;
        }
        else if ($c < 0xF8) {
          $s = 4;
        }
        // 5/6 byte sequences not possible for Unicode.
        else {
          $out[] = 0xFFFD;
          while (ord($txt{$i + 1}) >= 0x80 && ord($txt{$i + 1}) < 0xC0) { ++$i; }
          continue;
        }
        
        $q = array($c);
        // Fetch rest of sequence
        while (ord($txt{$i + 1}) >= 0x80 && ord($txt{$i + 1}) < 0xC0) { ++$i; $q[] = ord($txt{$i}); }
        
        // Check length
        if (count($q) != $s) {
          $out[] = 0xFFFD;
          continue;
        }
        
        switch ($s) {
          case 2:
            $cp = (($q[0] ^ 0xC0) << 6) | ($q[1] ^ 0x80);
            // Overlong sequence
            if ($cp < 0x80) {
              $out[] = 0xFFFD;
            }
            else {
              $out[] = $cp;
            }
            continue;

          case 3:
            $cp = (($q[0] ^ 0xE0) << 12) | (($q[1] ^ 0x80) << 6) | ($q[2] ^ 0x80);
            // Overlong sequence
            if ($cp < 0x800) {
              $out[] = 0xFFFD;
            }
            // Check for UTF-8 encoded surrogates (caused by a bad UTF-8 encoder)
            else if ($c > 0xD800 && $c < 0xDFFF) {
              $out[] = 0xFFFD;
            }
            else {
              $out[] = $cp;
            }
            continue;

          case 4:
            $cp = (($q[0] ^ 0xF0) << 18) | (($q[1] ^ 0x80) << 12) | (($q[2] ^ 0x80) << 6) | ($q[3] ^ 0x80);
            // Overlong sequence
            if ($cp < 0x10000) {
              $out[] = 0xFFFD;
            }
            // Outside of the Unicode range
            else if ($cp >= 0x10FFFF) {
              $out[] = 0xFFFD;
            }
            else {
              $out[] = $cp;
            }
            continue;
        }
      }
    }
    return $out;
  }

}

?>
