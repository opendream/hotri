<?php
/*
Plugin Name: Custom Permalinks
Plugin URI: http://michael.tyson.id.au/wordpress/plugins/custom-permalinks
Donate link: http://michael.tyson.id.au/wordpress/plugins/custom-permalinks
Description: Set custom permalinks on a per-post basis
Version: 0.5.2
Author: Michael Tyson
Author URI: http://michael.tyson.id.au
*/

/*  Copyright 2008 Michael Tyson <mike@tyson.id.au>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 ** Actions and filters
 **
 **/

/**
 * Filter to replace the post permalink with the custom one
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_post_link($permalink, $post) {
	$custom_permalink = get_post_meta( $post->ID, 'custom_permalink', true );
	if ( $custom_permalink ) {
		return get_option('home')."/".$custom_permalink;
	}
	
	return $permalink;
}


/**
 * Filter to replace the page permalink with the custom one
 *
 * @package CustomPermalinks
 * @since 0.4
 */
function custom_permalinks_page_link($permalink, $page) {
	$custom_permalink = get_post_meta( $page, 'custom_permalink', true );
	if ( $custom_permalink ) {
		return get_option('home')."/".$custom_permalink;
	}
	
	return $permalink;
}


/**
 * Filter to replace the term permalink with the custom one
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_term_link($permalink, $term) {
	$table = get_option('custom_permalink_table');
	if ( is_object($term) ) $term = $term->term_id;
	
	$custom_permalink = custom_permalinks_permalink_for_term($term);
	
	if ( $custom_permalink ) {
		return get_option('home')."/".$custom_permalink;
	}
	
	return $permalink;
}


/**
 * Action to redirect to the custom permalink
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_redirect() {
	
	// Get request URI, strip parameters
	$url = parse_url(get_bloginfo('url')); $url = $url['path'];
	$request = ltrim(substr($_SERVER['REQUEST_URI'], strlen($url)),'/');
	if ( ($pos=strpos($request, "?")) ) $request = substr($request, 0, $pos);
	
	global $wp_query;
	
	$custom_permalink = '';
	$original_permalink = '';

	// If the post/tag/category we're on has a custom permalink, get it and check against the request
	if ( is_single() || is_page() ) {
		$post = $wp_query->post;
		$custom_permalink = get_post_meta( $post->ID, 'custom_permalink', true );
		$original_permalink = ( $post->post_type == 'post' ? custom_permalinks_original_post_link( $post->ID ) : custom_permalinks_original_page_link( $post->ID ) );
	} else if ( is_tag() || is_category() ) {
		$theTerm = $wp_query->get_queried_object();
		$custom_permalink = custom_permalinks_permalink_for_term($theTerm->term_id);
		$original_permalink = (is_tag() ? custom_permalinks_original_tag_link($theTerm->term_id) :
							   			  custom_permalinks_original_category_link($theTerm->term_id));
	}
	
	if ( $custom_permalink && 
			(substr($request, 0, strlen($custom_permalink)) != $custom_permalink ||
			 $request == $custom_permalink."/" ) ) {
		// Request doesn't match permalink - redirect
		$url = $custom_permalink;
		if ( substr($request, 0, strlen($original_permalink)) == $original_permalink &&
				trim($request,'/') != trim($original_permalink,'/') ) {
			// This is the original link; we can use this url to derive the new one
			$url = preg_replace('@//*@', '/', str_replace(trim($original_permalink,'/'), trim($custom_permalink,'/'), $request));
			$url = preg_replace('@([^?]*)&@', '\1?', $url);
		}
		wp_redirect( get_option('home')."/".$url, 301 );
		exit();
	}	
}

/**
 * Filter to rewrite the query if we have a matching post
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_request($query) {
	global $wpdb;
	global $_CPRegisteredURL;
	
	// First, search for a matching custom permalink, and if found, generate the corresponding
	// original URL
	
	$originalUrl = '';
	
	// Get request URI, strip parameters and /'s
	$url = parse_url(get_bloginfo('url')); $url = $url['path'];
	$request = ltrim(substr($_SERVER['REQUEST_URI'], strlen($url)),'/');
	$request = (($pos=strpos($request, '?')) ? substr($request, 0, $pos) : $request);
	$request = preg_replace('@/+@','/', trim($request, '/'));
	
	if ( !$request ) return $query;
	
	$sql = "SELECT $wpdb->posts.ID, $wpdb->postmeta.meta_value, $wpdb->posts.post_type FROM $wpdb->posts ".
				" LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) WHERE ".
				"	meta_key = 'custom_permalink' AND ".
				"	meta_value != '' AND ".
				"	( meta_value = LEFT('".mysql_escape_string($request)."', LENGTH(meta_value)) OR ".
				"	  meta_value = LEFT('".mysql_escape_string($request."/")."', LENGTH(meta_value)) ) ".
				" ORDER BY LENGTH(meta_value) DESC";
	
	$posts = $wpdb->get_results($sql);
	
	if ( $posts ) {
		// A post matches our request
		
		// Preserve this url for later if it's the same as the permalink (no extra stuff)
		if ( trim($request,'/') == trim($posts[0]->meta_value,'/') ) 
			$_CPRegisteredURL = $request;
				
		$originalUrl = 	preg_replace('@/+@', '/', str_replace( trim($posts[0]->meta_value,'/'),
							       ( $posts[0]->post_type == 'post' ? 
											custom_permalinks_original_post_link($posts[0]->ID) 
											: custom_permalinks_original_page_link($posts[0]->ID) ),
								   trim( $request,'/' ) ));
	}
	
	if ( !$originalUrl ) {
		$table = get_option('custom_permalink_table');
		if ( !$table ) return $query;
	
		foreach ( array_keys($table) as $permalink ) {
			if ( $permalink == substr($request, 0, strlen($permalink)) || $permalink == substr($request."/", 0, strlen($permalink)) ) {
				$term = $table[$permalink];
				
				// Preserve this url for later if it's the same as the permalink (no extra stuff)
				if ( trim($request,'/') == trim($permalink,'/') ) 
					$_CPRegisteredURL = $request;
				
				
				if ( $term['kind'] == 'category') {
					$originalUrl = str_replace(trim($permalink,'/'),
										       custom_permalinks_original_category_link($term['id']),
											   trim($request,'/'));
				} else {
					$originalUrl = str_replace(trim($permalink,'/'),
										       custom_permalinks_original_tag_link($term['id']),
											   trim($request,'/'));
				}
			}
		}
	}
		
	if ( $originalUrl ) {
		
		if ( ($pos=strpos($_SERVER['REQUEST_URI'], '?')) !== false ) {
			$queryVars = substr($_SERVER['REQUEST_URI'], $pos+1);
			$originalUrl .= (strpos($originalUrl, '?') === false ? '?' : '&') . $queryVars;
		}
		
		// Now we have the original URL, run this back through WP->parse_request, in order to
		// parse parameters properly.  We set $_SERVER variables to fool the function.
		$oldPathInfo = $_SERVER['PATH_INFO']; $oldRequestUri = $_SERVER['REQUEST_URI']; $oldQueryString = $_SERVER['QUERY_STRING'];
		$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'] = '/'.ltrim($originalUrl,'/');
		$_SERVER['QUERY_STRING'] = (($pos=strpos($originalUrl, '?')) !== false ? substr($originalUrl, $pos+1) : '');
		parse_str($_SERVER['QUERY_STRING'], $queryArray);
		$oldValues = array();
		if ( is_array($queryArray) )
		foreach ( $queryArray as $key => $value ) {
			$oldValues[$key] = $_REQUEST[$key];
			$_REQUEST[$key] = $_GET[$key] = $value;
		}
				
		// Re-run the filter, now with original environment in place
		remove_filter( 'request', 'custom_permalinks_request', 10, 1 );
		global $wp;
		$wp->parse_request();
		$query = $wp->query_vars;
		add_filter( 'request', 'custom_permalinks_request', 10, 1 );
		
		// Restore values
		$_SERVER['PATH_INFO'] = $oldPathInfo; $_SERVER['REQUEST_URI'] = $oldRequestUri; $_SERVER['QUERY_STRING'] = $oldQueryString;
		foreach ( $oldValues as $key => $value ) {
			$_REQUEST[$key] = $value;
		}
	}

	return $query;
}

/**
 * Filter to handle trailing slashes correctly
 *
 * @package CustomPermalinks
 * @since 0.3
 */
function custom_permalinks_trailingslash($string, $type) {
	global $_CPRegisteredURL;
	if ( trim($_CPRegisteredURL,'/') == trim($string,'/') ) {
		return $_CPRegisteredURL;
	}
	return $string;
}


/**
 ** Administration
 **
 **/


/**
 * Per-post options
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_post_options() {
	global $post;
	$post_id = $post;
	if (is_object($post_id)) {
		$post_id = $post_id->ID;
	}
	
	$permalink = get_post_meta( $post_id, 'custom_permalink', true );
	
	?>
	<div class="postbox closed">
	<h3><?php _e('Custom Permalink', 'custom-permalink') ?></h3>
	<div class="inside">
	<?php custom_permalinks_form($permalink, custom_permalinks_original_post_link($post_id)); ?>
	</div>
	</div>
	<?php
}


/**
 * Per-page options
 *
 * @package CustomPermalinks
 * @since 0.4
 */
function custom_permalinks_page_options() {
	global $post;
	$post_id = $post;
	if (is_object($post_id)) {
		$post_id = $post_id->ID;
	}
	
	$permalink = get_post_meta( $post_id, 'custom_permalink', true );
	
	?>
	<div class="postbox closed">
	<h3><?php _e('Custom Permalink', 'custom-permalink') ?></h3>
	<div class="inside">
	<?php custom_permalinks_form($permalink, custom_permalinks_original_page_link($post_id)); ?>
	</div>
	</div>
	<?php
}


/**
 * Per-category/tag options
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_term_options($object) {

	$permalink = custom_permalinks_permalink_for_term($object->term_id);
	
	if ( $object->term_id ) {
    	$originalPermalink = ($object->taxonomy == 'post_tag' ? 
    								custom_permalinks_original_tag_link($object->term_id) :
    								custom_permalinks_original_category_link($object->term_id) );
    }
    	
	custom_permalinks_form($permalink, $originalPermalink);

	// Move the save button to above this form
	wp_enqueue_script('jquery');
	?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		var button = jQuery('#custom_permalink_form').parent().find('.submit');
		button.remove().insertAfter(jQuery('#custom_permalink_form'));
	});
	</script>
	<?php
}

/**
 * Helper function to render form
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_form($permalink, $original="") {
	?>
	<input value="true" type="hidden" name="custom_permalinks_edit" />
	<input value="<?php echo htmlspecialchars($permalink) ?>" type="hidden" name="custom_permalink" id="custom_permalink" />
	
	<table class="form-table" id="custom_permalink_form">
	<tr>
		<th scope="row"><?php _e('Custom Permalink', 'custom-permalink') ?></th>
		<td>
			<?php echo get_option('home') ?>/
			<input type="text" class="text" value="<?php echo htmlspecialchars($permalink ? $permalink : $original) ?>" 
				style="width: 250px; <?php if ( !$permalink ) echo 'color: #ddd;' ?>"
			 	onfocus="if ( this.value == '<?php echo htmlspecialchars($original) ?>' ) { this.value = ''; this.style.color = '#000'; }" 
				onblur="document.getElementById('custom_permalink').value = this.value; if ( this.value == '' ) { this.value = '<?php echo htmlspecialchars($original) ?>'; this.style.color = '#ddd'; }"/><br />
			<small><?php _e('Leave blank to disable', 'custom-permalink') ?></small>
		</td>
	</tr>
	</table>
	<?php
}


/**
 * Save per-post options
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_save_post($id) {
	if ( !isset($_REQUEST['custom_permalinks_edit']) ) return;
	
	delete_post_meta( $id, 'custom_permalink' );
	if ( $_REQUEST['custom_permalink'] && $_REQUEST['custom_permalink'] != custom_permalinks_original_post_link($id) )
		add_post_meta( $id, 'custom_permalink', ltrim(stripcslashes($_REQUEST['custom_permalink']),"/") );
}


/**
 * Save per-tag options
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_save_tag($id) {
	if ( !isset($_REQUEST['custom_permalinks_edit']) ) return;
	$newPermalink = ltrim(stripcslashes($_REQUEST['custom_permalink']),"/");
	
	if ( $newPermalink == custom_permalinks_original_tag_link($id) )
		$newPermalink = ''; 
	
	$term = get_term($id, 'post_tag');
	custom_permalinks_save_term($term, $newPermalink);
}

/**
 * Save per-category options
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_save_category($id) {
	if ( !isset($_REQUEST['custom_permalinks_edit']) ) return;
	$newPermalink = ltrim(stripcslashes($_REQUEST['custom_permalink']),"/");
	
	if ( $newPermalink == custom_permalinks_original_category_link($id) )
		$newPermalink = ''; 
	
	$term = get_term($id, 'category');
	custom_permalinks_save_term($term, $newPermalink);
}

/**
 * Save term (common to tags and categories)
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_save_term($term, $permalink) {
	
	custom_permalinks_delete_term($term->term_id);
	$table = get_option('custom_permalink_table');
	if ( $permalink )
		$table[$permalink] = array(
			'id' => $term->term_id, 
			'kind' => ($term->taxonomy == 'category' ? 'category' : 'tag'),
			'slug' => $term->slug);

	update_option('custom_permalink_table', $table);
}


/**
 * Delete term
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_delete_term($id) {
	
	$table = get_option('custom_permalink_table');
	if ( $table )
	foreach ( $table as $link => $info ) {
		if ( $info['id'] == $id ) {
			unset($table[$link]);
			break;
		}
	}
	
	update_option('custom_permalink_table', $table);
}

/**
 * Options page
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_options_page() {
	
	// Handle revert
	if ( isset($_REQUEST['revertit']) && isset($_REQUEST['revert']) ) {
		check_admin_referer('custom-permalinks-bulk');
		foreach ( (array)$_REQUEST['revert'] as $identifier ) {
			list($kind, $id) = explode('.', $identifier);
			switch ( $kind ) {
				case 'post':
				case 'page':
					delete_post_meta( $id, 'custom_permalink' );
					break;
				case 'tag':
				case 'category':
					custom_permalinks_delete_term($id);
					break;
			}
		}
		
		// Redirect
		$redirectUrl = $_SERVER['REQUEST_URI'];
		?>
		<script type="text/javascript">
		document.location = '<?php echo $redirectUrl ?>';
		</script>
		<?php
	}
	
	?>
	<div class="wrap">
	<h2><?php _e('Custom Permalinks', 'custom-permalinks') ?></h2>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
	<?php wp_nonce_field('custom-permalinks-bulk') ?>
	
	<div class="tablenav">
	<div class="alignleft">
	<input type="submit" value="<?php _e('Revert', 'custom-permalinks'); ?>" name="revertit" class="button-secondary delete" />
	</div>
	<br class="clear" />
	</div>
	<br class="clear" />
	<table class="widefat">
		<thead>
		<tr>
			<th scope="col" class="check-column"><input type="checkbox" /></th>
			<th scope="col"><?php _e('Title', 'custom-permalinks') ?></th>
			<th scope="col"><?php _e('Type', 'custom-permalinks') ?></th>
			<th scope="col"><?php _e('Permalink', 'custom-permalinks') ?></th>
		</tr>
		</thead>
		<tbody>
	<?php
	$rows = custom_permalinks_admin_rows();
	foreach ( $rows as $row ) {
		?>
		<tr valign="top">
		<th scope="row" class="check-column"><input type="checkbox" name="revert[]" value="<?php echo $row['id'] ?>" /></th>
		<td><strong><a class="row-title" href="<?php echo htmlspecialchars($row['editlink']) ?>"><?php echo htmlspecialchars($row['title']) ?></a></strong></td>
		<td><?php echo htmlspecialchars($row['type']) ?></td>
		<td><a href="<?php echo $row['permalink'] ?>" target="_blank" title="Visit <?php echo htmlspecialchars($row['title']) ?>">
			<?php echo htmlspecialchars($row['permalink']) ?>
			</a>
		</td>
		</tr>
		<?php
	}
	?>
	</tbody>
	</table>
	</form>
	</div>
	<?php
}

/**
 * Get rows for management view
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_admin_rows() {
	$rows = array();
	
	// List tags/categories
	$table = get_option('custom_permalink_table');
	if ( $table && is_array($table) ) {
		foreach ( $table as $permalink => $info ) {
			$row = array();
			$term = get_term($info['id'], ($info['kind'] == 'tag' ? 'post_tag' : 'category'));
			$row['id'] = $info['kind'].'.'.$info['id'];
			$row['permalink'] = get_option('home')."/".$permalink;
			$row['type'] = ucwords($info['kind']);
			$row['title'] = $term->name;
			$row['editlink'] = ( $info['kind'] == 'tag' ? 'edit-tags.php?action=edit&tag_ID='.$info['id'] : 'categories.php?action=edit&cat_ID='.$info['id'] );
			$rows[] = $row;
		}
	}
	
	// List posts/pages
	global $wpdb;
	$query = "SELECT $wpdb->posts.* FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) WHERE ".
	 			"$wpdb->postmeta.meta_key = 'custom_permalink' AND $wpdb->postmeta.meta_value != ''";
	$posts = $wpdb->get_results($query);
	foreach ( $posts as $post ) {
		$row = array();
		$row['id'] = 'post.'.$post->ID;
		$row['permalink'] = get_permalink($post->ID);
		$row['type'] = ucwords( $post->post_type );
		$row['title'] = $post->post_title;
		$row['editlink'] = ( $post->post_type == 'post' ? 'post.php' : 'page.php' ) . '?action=edit&post='.$post->ID;
		$rows[] = $row;
	}
	
	return $rows;
}


/**
 * Get original permalink for post
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_original_post_link($post_id) {
	remove_filter( 'post_link', 'custom_permalinks_post_link', 10, 2 );
	$originalPermalink = ltrim(str_replace(get_option('home'), '', get_permalink( $post_id )), '/');
	add_filter( 'post_link', 'custom_permalinks_post_link', 10, 2 );
	return $originalPermalink;
}

/**
 * Get original permalink for page
 *
 * @package CustomPermalinks
 * @since 0.4
 */
function custom_permalinks_original_page_link($post_id) {
	remove_filter( 'page_link', 'custom_permalinks_page_link', 10, 2 );
	$originalPermalink = ltrim(str_replace(get_option('home'), '', get_permalink( $post_id )), '/');
	add_filter( 'page_link', 'custom_permalinks_page_link', 10, 2 );
	return $originalPermalink;
}


/**
 * Get original permalink for tag
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_original_tag_link($tag_id) {
	remove_filter( 'tag_link', 'custom_permalinks_term_link', 10, 2 );
	$originalPermalink = ltrim(str_replace(get_option('home'), '', get_tag_link($tag_id)), '/');
	add_filter( 'tag_link', 'custom_permalinks_term_link', 10, 2 );
	return $originalPermalink;
}

/**
 * Get original permalink for category
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_original_category_link($category_id) {
	remove_filter( 'category_link', 'custom_permalinks_term_link', 10, 2 );
	$originalPermalink = ltrim(str_replace(get_option('home'), '', get_category_link($category_id)), '/');
	add_filter( 'category_link', 'custom_permalinks_term_link', 10, 2 );
	return $originalPermalink;
}

/**
 * Get permalink for term
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_permalink_for_term($id) {
	$table = get_option('custom_permalink_table');
	if ( $table )
	foreach ( $table as $link => $info ) {
		if ( $info['id'] == $id ) {
			return $link;
		}
	}
	return false;
}

/**
 * Set up administration
 *
 * @package CustomPermalinks
 * @since 0.1
 */
function custom_permalinks_setup_admin() {
	add_management_page( 'Custom Permalinks', 'Custom Permalinks', 5, __FILE__, 'custom_permalinks_options_page' );
	if ( is_admin() )
		wp_enqueue_script('admin-forms');
}


add_action( 'template_redirect', 'custom_permalinks_redirect', 5 );
add_filter( 'post_link', 'custom_permalinks_post_link', 10, 2 );
add_filter( 'page_link', 'custom_permalinks_page_link', 10, 2 );
add_filter( 'tag_link', 'custom_permalinks_term_link', 10, 2 );
add_filter( 'category_link', 'custom_permalinks_term_link', 10, 2 );
add_filter( 'request', 'custom_permalinks_request', 10, 1 );
add_filter( 'user_trailingslashit', 'custom_permalinks_trailingslash', 10, 2 );

add_action( 'edit_form_advanced', 'custom_permalinks_post_options' );
add_action( 'edit_page_form', 'custom_permalinks_page_options' );
add_action( 'edit_tag_form', 'custom_permalinks_term_options' );
add_action( 'add_tag_form', 'custom_permalinks_term_options' );
add_action( 'edit_category_form', 'custom_permalinks_term_options' );
add_action( 'save_post', 'custom_permalinks_save_post' );
add_action( 'edited_post_tag', 'custom_permalinks_save_tag' );
add_action( 'edited_category', 'custom_permalinks_save_category' );
add_action( 'create_post_tag', 'custom_permalinks_save_tag' );
add_action( 'create_category', 'custom_permalinks_save_category' );
add_action( 'delete_post_tag', 'custom_permalinks_delete_term' );
add_action( 'delete_post_category', 'custom_permalinks_delete_term' );
add_action( 'admin_menu', 'custom_permalinks_setup_admin' );

?>
