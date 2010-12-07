<?php
/*
OpenURL() constructs an NISO Z39.88 compliant ContextObject for use in OpenURL links and COinS.  It returns 
the proper query string, which you must embed in a <span></span> thus:
 
<span class="Z3988" title="<?php print OpenURL($Document, $People) ?>">Content of your choice goes here</span>
 
This span will work with Zotero. You can also use the output of OpenURL() to link to your library's OpenURL resolver, thus:
 
<a href="http://www.lib.utexas.edu:9003/sfx_local?<?php print OpenURL($Document, $People); ?>" title="Search for a copy of this document in UT's libraries">Find it at UT!</a>
 
Replace "http://www.lib.utexas.edu:9003/sfx_local?" with the correct resolver for your library.
 
OpenURL() takes two arguments.
 
$Document - a document object, having an array (fields) with the following properties:
  $Document->fields["DocType"]
    1 = Article
    2 = Book Item (e.g. a chapter, section, etc)
    3 = Book
    4 = Unpublished MA thesis
    5 = Unpublished PhD thesis
 
  $Document->fields["DocTitle"] - Title of the document.
  $Document->fields["JournalTitle"] - Title of the journal/magazine the article was published in, or false if this is not an article.
 
  $Document->fields["BookTitle"] - Title of the book in which this item was published, or false if this is not a book item.
 
  $Document->fields["Volume"] - The volume of the journal this article was published in as an integer, or false if this is not an article.  Optional.
  $Document->fields["JournalIssue"] - The issue of the journal this article was published in as an integer, or false if this is not an article.  Optional.
  $Document->fields["JournalSeason"] Optional.
    The season of the journal this article was published in, as a string, where:
      Spring
      Summer
      Fall
      Winter
      false = not applicable
  $Document->fields["JournalQuarter"] - The quarter of the journal this article was published in as an integer between 1 and 4, or false. Optional.
  $Document->fields["ISSN"] - The volume of the journal this article was published in, or false.  Optional.
 
 
  $Document->fields["BookPublisher"] - The publisher of the book, or false. Optional.
  $Document->fields["PubPlace"] - The publication place, or false.  Optional.
  $Document->fields["ISBN"] - The ISBN of the book.  Optional but highly recommended.
 
  $Document->fields["StartPage"] - Start page for the article or item, or false if this is a complete book.
  $Document->fields["EndPage"] - End page for the article or item, or false if this is a complete book.
 
$Document->fields["DocYear"] - The year in which this document was published.
 
$People - An array of person objects, each having an array, fields, with these properties:
  $People->fields["DocRelationship"]
    An integer indicating what kind of relationship the person has to this document.
    0 = author
    1 = editor
    2 = translator
  $People->fields["FirstName"] - The person's first name.
  $People->fields["LastName"] - The person's last name.
*/
function OpenURL($document, $people) {
  $fields = $document->fields;
  
  switch ($fields['DocType']) {
    case 0:
      $params = array(
        'rft_val_fmt' => 'info:ofi/fmt:kev:mtx:journal',
        'rft.genre' => 'article',
      );
      
      $variables = array(
        'atitle' => 'DocTitle',
        'jtitle' => 'JournalTitle',
        'stitle' => 'ShortTitle',
        'volume' => 'Volume',
        'issue' => 'JournalIssue',
        'ssn' => 'JournalSeason',
        'quarter' => 'JournalQuarter',
        'issn' => 'ISSN',
        'spage' => 'StartPage',
        'epage' => 'EndPage',
        'date' => 'DocYear',
      );
      break;
    case 1:
      $params = array(
        'rft_val_fmt' => 'info:ofi/fmt:kev:mtx:book',
        'rft.genre' => 'bookitem',
      );
      
      $variables = array(
        'atitle' => 'DocTitle',
        'btitle' => 'BookTitle',
        'pub' => 'BookPublisher',
        'place' => 'PubPlace',
        'isbn' => 'ISBN',
        'spage' => 'StartPage',
        'epage' => 'EndPage',
        'date' => 'DocYear',
      );
      break;
    case 2:
      $params = array(
        'rft.genre' => 'book',
        'rft_val_fmt' => 'info:ofi/fmt:kev:mtx:book',
      );
      
      $variables = array(
        'btitle' => 'DocTitle',
        'pub' => 'BookPublisher',
        'place' => 'PubPlace',
        'isbn' => 'ISBN',
        'date' => 'DocYear',
        'edition' => 'DocEdition',
      );
      break;
  }
  
  $params_header = array(
    'ctx_ver' => 'Z39.88-2004',
    'rfr_id' => 'info:sid/' . $_SERVER['SERVER_NAME'] . ':' . $fields['Id'],
    'rft_id' => urlencode('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']),
  );
  
  $params = array_merge($params_header, $params);
 
  // Authors
  foreach ($people as $p){
    if($p->fields['DocRelationship'] == 0 && $p->fields['FirstName'] != ''){
      $fields['Author'] = $p->fields['LastName'] . ', ' . $p->fields['FirstName'];
      $variables['au'] = 'Author';
    }
  }
  
  $url = '';
  foreach ($variables as $key => $val) {
    // skip empty / not-exist field to avoid PHP 5.3 warning
    if (!empty($fields[$val])) {
      $params['rft.' . $key] = $fields[$val];
    }
    
  }
  
  //print_r($variables);
  
  // Return encoded URL
  foreach ($params as $key => $val) {
    $url .= $key . '=' . urlencode($val) . '&amp;';
  }
  
  return substr($url, 0, -5);
}

