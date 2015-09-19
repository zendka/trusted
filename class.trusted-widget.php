<?php

class Trusted_Widget extends WP_Widget {

    const VERIFICATION_URL = 'http://trusted.ro/assets/verify.php?id=';

    /**
     *  Sets up the widgets name, etc.
     */
    public function __construct() {

        parent::__construct(
            'trusted_widget', // Base ID
            __( 'Trusted Badge', 'trusted' ), // Name
            array( 'description' => __( 'A badge with the Trusted.ro logo.', 'trusted' ) ) // Args
        );
    }

    /**
     * Outputs the back-end widget form
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        // Text input for Title
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php

        // Text input for Trusted ID
        $trusted_id = ! empty( $instance[ 'trusted_id' ] ) ? $instance[ 'trusted_id' ] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'trusted_id' ); ?>"><?php _e( 'Trusted ID:', 'trusted' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'trusted_id' ); ?>" name="<?php echo $this->get_field_name( 'trusted_id' ); ?>" type="text" value="<?php echo esc_attr( $trusted_id ); ?>" />
        </p>
        <?php
    }

    /**
     * Processes the back-end widget form on save
     *
     * Sanitizes form values.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {

        $instance = array();
        $instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['trusted_id'] = ( ! empty( $new_instance['trusted_id'] ) ) ? strip_tags( $new_instance['trusted_id'] ) : '';

        return $instance;
    }

    /**
     * Outputs the content of the widget on the frontend
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        // Before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // Widget title
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        // Widget body
        $url = self::VERIFICATION_URL . urlencode( $instance[ 'trusted_id' ] );
        ?>
        <a title="Afla detalii despre acest magazin" style="cursor: pointer;"
            onclick="window.open('<?php echo $url; ?>', 'trusted', 'location=no, scrollbars=yes, resizable=yes, toolbar=no, menubar=no, width=600, height=700'); return false;">
            <img src="<?php echo TRUSTED__PLUGIN_URL . 'img/logo_trusted_vertical.png'; ?>">
        </a>
        <?php

        echo $args['after_widget'];
    }
}

// Register widget
add_action( 'widgets_init', function(){
    register_widget( 'Trusted_Widget' );
});
