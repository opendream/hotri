<?php
/*
Template Name: OPAC Search Results
*/

get_header(); 
  
  $_GET['opac'] = stripslashes($_GET['opac']);
?>
	<div id="content" class="narrowcolumn" role="main">
	  <div class="post" id="post-<?php the_ID(); ?>">
	    <h2><?php the_title(); echo " - " . $_GET['opac']; ?></h2>
	    <?php
	    $limit = 10; // Page limit
	    if (0 + $_GET['page'] > 0) 
	      $qpage = "&start=" . ((-1 + $_GET['page']) * $limit) . "&items=$limit";
	    $response = unserialize(file_get_contents('http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . "/../api/opac.php?keyword=" . urlencode($_GET['opac']) . "{$qpage}"));
	    
	    if (!is_array($response['data'])) { // Failed or not found
	      echo "<div class=\"book-no-item\">Search with keyword '{$_GET['opac']}' get no results.</div>"; 
	    }
	    else {
	      // Paging
	      if ($response['rows'] > $limit) {
	        $page = 0 + $_GET['page'];
	        if ($page == 0) $page = 1;

	        $page_range = 2;
	        
	        $paging = "<span class=\"paging-nav\">Page: ";

	        if ($page > $page_range + 1) {
	          $paging .= "<a href=\"?opac=" . urlencode($_GET['opac']) . "\"><<</a> .. ";
	        }
	        // Start render from minimal page range
          if ($page - $page_range < 1) 
            $start_paging = 1;
          else 
            $start_paging = $page - $page_range;
          
	        for ($i = $start_paging; $i <= ceil($response['rows'] / $limit); $i++) {
	          if ($i > $page + $page_range) 
	            break;
	          
            if ($page == $i) 
              $paging .= "$i . ";
            else
              $paging .= "<a href=\"?opac=" . urlencode($_GET['opac']) . "&page=$i\">$i</a> . ";
          
	        }
	        
	        $paging = substr($paging, 0, -3);

	        if ($page + $page_range < $response['rows'] / $limit)
	          $paging .= " .. <a href=\"?opac=" . urlencode($_GET['opac']) . "&page=" . ceil($response['rows'] / $limit) . "\"> >> </a>";

	        $paging .= "</span>";
	      }

	      echo $paging;
	      foreach ($response['data'] as $book) {
	        echo "<div class=\"book-item\">
      <div class=\"book-cover\"><a href=\"?opac&view={$book['id']}\"><img src=\"../pictures/{$book['cover']}\" alt=\"{$book['title']}\" /></a></div>
      <table class=\"book-info\">
        <tr><td>Title:</td><td><a href=\"?opac&view={$book['id']}\">{$book['title']}</a></td></tr>
        <tr><td>Author:</td><td>{$book['author']}</td></tr>
        <tr><td>Material:</td><td>{$book['material']}</td></tr>
        <tr><td>Collection:</td><td>{$book['collection']}</td></tr>
        <tr><td>Call Number:</td><td>{$book['call_no']}</td></tr>
      </table>
      <hr />
	  </div>
  ";
	      }
	    }
	    echo $paging;
	    ?>
	  </div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
