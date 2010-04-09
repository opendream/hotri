<?php
/**
 * Plugin Name: OpenBiblio OPAC Widget
 * Plugin URI: http://example.com/widget
 * Description: A widget that display search box integrate with OpenBiblio.
 * Version: 0.1
 * Author: Teerapong Kraiamornchai
 * Author URI: http://twitter.com/aimakun
 *
 * DEVELOPMENT VERSION, BE CAREFUL FOR USE IT.
 */

add_action( 'widgets_init', 'obopac_load_widgets' );

function obopac_load_widgets() {
	register_widget( 'ObOpac_Widget' );
}

class ObOpac_Widget extends WP_Widget {
  /**
	 * Widget setup.
	 */
  function ObOpac_Widget() {
    /* Widget settings. */
		$widget_ops = array( 'classname' => 'opac-search', 'description' => __('Search widget for openbiblio.', 'obopac') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'obopac-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'obopac-widget', __('Search OPAC Widget', 'obopac'), $widget_ops, $control_ops );
  }

  function form($instance) {
		// outputs the options form on admin
		//$instance = wp_parse_args( (array) $instance, array( 'api_path' => '../') );
		//$path = esc_attr( $instance['api_path'] );
		$path = get_option('obopac_api_path');
     ?>
          <p><label for="<?php echo $this->get_field_id('api_path'); ?>"><?php _e('OpenBiblio Path:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('api_path'); ?>" name="<?php echo $this->get_field_name('api_path'); ?>" type="text" value="<?php echo $path; ?>" /></label></p>
     <?php 
	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance['api_path'] = strip_tags(stripslashes($new_instance['api_path']));
		if (substr($instance['api_path'], strlen($instance['api_path']) -1) != '/') 
		  $instance['api_path'] .= '/';

		update_option("obopac_api_path", $instance['api_path']);
		
		return $instance;
	}


  /**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		// None.

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

    $options = array('title' => 'Title', 'author' => 'Author', 'subject' => 'Subject');
    $option_form = '';
    foreach ($options as $op=>$label) {
      $option_form .= '<option value="' . $op . '"';
		  if ($_GET['type'] == $op) 
		    $option_form .= ' selected="selected"';

		  $option_form .= ">$label</option>\n";
		}

	  /* Display search box */
	  $opac = htmlspecialchars(urldecode($_GET[opac]));
	  echo <<<INNERHTML
<form method="get" action="?">
  <input type="text" name="opac" value="$opac" /> 
  <select name="type">
    $option_form
  </select>
  <input type="submit" name="submit" value="Searh OPAC" />
</form>
INNERHTML;

		/* After widget (defined by themes). */
		echo $after_widget;
	}
}
