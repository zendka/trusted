<?php
/*
Plugin Name: Trusted
Description: Allows shop owners to add a widget with the Trusted.ro badge
Version: 1.0
Author: Florin Buga
License: GPL2
*/

class Trusted_Widget extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => __( 'A badge with the Trusted.ro logo.', 'trusted' ) );
		parent::__construct( 'trusted_widget', __( 'Trusted Badge', 'trusted' ), $widget_ops );
	}


	// Widget front-end
	public function widget( $args, $instance ) {

		// Before and after widget arguments are defined by themes
		echo $args['before_widget'];

		// Widget title
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'];
			echo apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
			echo $args['after_title'];
		}
		
		// Widget body
		$url  = 'http://trusted.ro/assets/verify.php?id=';
		$url .= empty( $instance['trusted_id'] ) ? '' : urlencode( $instance[ 'trusted_id' ] );
		?>
		<a class="trusted" title="Afla detalii despre acest magazin" style="cursor: pointer;" 
			onclick="window.open('<?php echo $url; ?>', 'TRUSTED', 'location=no, scrollbars=yes, resizable=yes, toolbar=no, menubar=no, width=600, height=700'); return false;">		
			<img src="<?php echo plugins_url( 'img/logo_trusted_vertical.png', __FILE__ ); ?>">
		</a>
		<?php

		echo $args['after_widget'];
	}
	
	
	// Widget backend
	public function form( $instance ) {
		
		// Input for widget title
		$title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title:' ); ?>
			</label> 
			<input type="text"
				class="widefat"
				id="<?php echo $this->get_field_id( 'title' ); ?>"
				name="<?php echo $this->get_field_name( 'title' ); ?>"
				value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
		
		// Input for Trusted ID
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'trusted_id' ); ?>">
				<?php __( 'Trusted ID:', 'trusted' ); ?>
			</label> 
			<input type="text"
				class="widefat"
				id="<?php echo $this->get_field_id( 'trusted_id' ); ?>"
				name="<?php echo $this->get_field_name( 'trusted_id' ); ?>"
				value="<?php echo empty( $instance[ 'trusted_id' ] ) ? '' : esc_attr( $instance[ 'trusted_id' ] ); ?>" />
		</p>
		<?php 
	}
	
	
	// Sanitize widget form values as they are saved
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title']      = empty( $new_instance['title'] )      ? '' : strip_tags( $new_instance['title'] );
		$instance['trusted_id'] = empty( $new_instance['trusted_id'] ) ? '' : strip_tags( $new_instance['trusted_id'] );

		return $instance;
	}

}


// Register widget
function trusted_load_widget() {
	register_widget( 'Trusted_Widget' );
}
add_action( 'widgets_init', 'trusted_load_widget' );
