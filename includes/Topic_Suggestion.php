<?php
class Topic_Suggestion_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'wordsesh_topic',
			__( 'Topic Suggestion', 'wordsesh' ),
			array( 'description' => __( 'Solicit blog post ideas', 'wordsesh' ) )
		);

		add_action( 'wp_ajax_wordsesh_form_submit', array( $this, 'submit' ) );
		add_action( 'wp_ajax_nopriv_wordsesh_form_submit', array( $this, 'submit' ) );
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div id="wordsesh_form">';

		echo $this->process_form();

		echo '</div>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Suggest a Post', 'wordsesh' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
	<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	public function submit() {
		echo $this->process_form();

		die();
	}

	protected function process_form() {
		if ( isset( $_POST['wordsesh_submit'] ) ) {
			// Process the form data.

			return '<p>' . __( 'Thanks so much for your idea!', 'wordsesh' ) . '</p>';
		} else {
			$output = '<form id="wordsesh_form_inner" action="" method="post">';
			$output .= '<p><label for="wordsesh_title">' . __( 'Post Title', 'wordsesh' ) . '</label>';
			$output .= '<input type="text" id="wordsesh_title" name="wordsesh_title" /></p>';
			$output .= '<p><label for="wordsesh_topic">' . __( 'Description', 'wordsesh' ) . '</label>';
			$output .= '<textarea cols="3" rows="5" id="wordsesh_topic" name="wordsesh_topic"></textarea></p>';
			$output .= '<p><input type="submit" value="' . __( 'Submit' ) . '" id="wordsesh_submit" name="wordsesh_submit" /></p>';
			$output .= '</form>';

			return $output;
		}
	}
}