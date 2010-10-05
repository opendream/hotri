<?php
/*
Template Name: OPAC Search Results
*/

get_header(); 
  
  $_GET['opac'] = stripslashes($_GET['opac']);
?>
	<div id="content" class="narrowcolumn" role="main">
	  <div class="post">
	    <h2><?php the_title(); echo " - " . $_GET['opac']; ?></h2>
	    <h4>Search by: <?php echo empty($_GET['type'])?'title':$_GET['type'] ?></h4>
	    <?php
	    $limit = 10; // Page limit
	    $qpage = "&type=" . $_GET['type'];
	    if (0 + $_GET['page'] > 0) 
	      $qpage .= "&start=" . ((-1 + $_GET['page']) * $limit) . "&items=$limit";

	    $path = get_option("obopac_api_path");
	    $response = unserialize(file_get_contents($path . "api/opac.php?keyword=" . urlencode($_GET['opac']) . "{$qpage}"));
	    
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
	          $paging .= "<a href=\"?opac=" . urlencode($_GET['opac']) . "&type=" . urlencode($_GET['type']) . "\"><<</a> .. ";
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
              $paging .= "<a href=\"?opac=" . urlencode($_GET['opac']) . "&type=" . urlencode($_GET['type']) . "&page=$i\">$i</a> . ";
          
	        }
	        
	        $paging = substr($paging, 0, -3);

	        if ($page + $page_range < $response['rows'] / $limit)
	          $paging .= " .. <a href=\"?opac=" . urlencode($_GET['opac']) . "&type=" . urlencode($_GET['type']) . "&page=" . ceil($response['rows'] / $limit) . "\"> >> </a>";

	        $paging .= "</span>";
	      }

	      echo $paging;
	      foreach ($response['data'] as $book) {
	        echo "<div class=\"book-item\">
      <div class=\"book-cover\"><a href=\"?opac&view={$book['id']}\"><img src=\"{$book['cover']}\" alt=\"{$book['title']}\" /></a></div>
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
