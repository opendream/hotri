<?php
/*
Template Name: OPAC bibliography
*/

get_header(); 
        $path = get_option("obopac_api_path");
  	    $response = unserialize(file_get_contents($path . "api/opac.php?id=" . (0 + $_GET['view'])));
  	    ?>
	<div id="content" class="narrowcolumn" role="main">
	  <div class="post">
	    <?php if (!is_array($response)) { ?>
	      <p>Could not retrieve bibliography.</p>
	    <?php } else { ?>
	    <h2><?php echo $response['title'] ?></h2>
      <?php
      if (!empty($response['subtitle'])) 
	      echo "<h4>{$response['subtitle']}</h4>\n";
	    ?>
	    <p id="biblio-top-backlink">
	      <a href="#" onclick="javascript:history.back(); return false;">Back to results</a>
	    </p>
	    <?php

	      if (!empty($response['cover'])) 
	        echo "<div class=\"book-cover\"><img src=\"{$response['cover']}\" alt=\"{$response['title']}\"></div>\n";

        $trans = array(
          'responsibility' => 'คณะผู้จัดทำ',
          'author' => 'ผู้แต่ง',
          'call_no' => 'เลขเรียกหนังสือ',
          'collection' => 'หมวด',
          'material' => 'ประเภท',
        );
	      unset($response['title'], $response['subtitle'], $response['id'], $response['cover']);
	      echo "<table class=\"book-info\">\n";
  	    foreach ($response as $key=>$info) {
  	      if (is_array($info)) continue;
  	      if (empty($info)) continue;
  	      echo "<tr><td class=\"label\">" . ($trans[$key] ? $trans[$key] : $key) . "</td><td class=\"info\">" . $info . "</td></tr>\n";
  	    }
  	    echo "</table>\n";

        echo "<h4>Copy Informations</h4>\n";
        if (is_array($response['copies']) && count($response['copies']) > 0) {
          echo "<table class=\"book-copies\">\n";
          echo "<tr>";
	        foreach ($response['copies'][0] as $key=>$val) {
	          echo "<th>$key</th>";
	        }
	        echo "</tr>\n";
    	    foreach ($response['copies'] as $copy) {
    	      if (is_array($copy)) {
    	        echo "<tr>";
    	        foreach ($copy as $val) {
    	          echo "<td>$val</td>";
    	        }
    	        echo "</tr>\n";
    	      }
    	      else {
    	        echo "<tr><td>Empty copy</td></tr>";
    	      }
    	    }
  	      echo "</table>";
  	    }
  	    else {
  	      echo "<p>No copy</p>";
  	    }

  	    echo "<h4>Book Descriptions</h4>";
  	    echo "<div id=\"marc-info\">";
  	    foreach ($response['marc'] as $key=>$vals) {
  	      if (!empty($vals['label'])) 
  	        echo "<div class=\"marc-label\"><em>{$vals['label']}</em></div><div class=\"marc-value\">{$vals['value']}</div>";
  	    }
  	    echo "</div>";
	    ?>
	    <hr />
	    <a href="#" onclick="javascript:history.back(); return false;">Back</a>
      <?php } ?>
	  </div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
