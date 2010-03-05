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

	  /* Display search box */
	  echo <<<INNERHTML
<form method="post" action="../shared/biblio_search.php">
  <input type="text" name="searchText" />
  <input type="hidden" name="searchType" value="title" />
  <input type="hidden" name="sortBy" value="default" />
  <input type="hidden" name="tab" value="opac" />
  <input type="hidden" name="lookup" value="N" />
  <input type="submit" name="submit" value="Searh OPAC" />
</form>
INNERHTML;

		/* After widget (defined by themes). */
		echo $after_widget;
	}
}
