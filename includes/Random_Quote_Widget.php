<?php
class Random_Quote_Widget extends WP_Widget {
	/**
	 * Individual quotes take the format of an array - ( quote, attribution )
	 *
	 * @var array
	 */
	protected $quotes = array(
		array( 'The first 90% of the code accounts for the first 90% of the development time. The remaining 10% of the code accounts for the other 90% of the development time.', 'Tom Cargill' ),
		array( 'In order to understand recursion, one must first understand recursion.', 'Unknown' ),
		array( 'I have always wished for my computer to be as easy to use as my telephone; my wish has come true because I can no longer figure out how to use my telephone.', 'Bjarne Stroustrup' ),
		array( 'A computer lets you make more mistakes faster than any other invention in human history, with the possible exceptions of handguns and tequila.', 'Mitch Ratcliffe' ),
		array( 'There are two ways of constructing a software design: One way is to make it so simple that there are obviously no deficiencies, and the other way is to make it so complicated that there are no obvious deficiencies. The first method is far more difficult.', 'C.A.R. Hoare' ),
		array( 'The gap between theory and practice is not as wide in theory as it is in practice.', 'Unknown' ),
		array( 'If builders built buildings the way programmers wrote programs, then the first woodpecker that came along would destroy civilization.', 'Gerald Weinberg' ),
		array( 'If debugging is the process of removing software bugs, then programming must be the process of putting them in.', 'Edsger Dijkstra' ),
		array( 'Measuring programming progress by lines of code is like measuring aircraft building progress by weight.', 'Bill Gates' ),
		array( 'Nine people can’t make a baby in a month.', 'Fred Brooks' ),
		array( 'Programming today is a race between software engineers striving to build bigger and better idiot-proof programs, and the Universe trying to produce bigger and better idiots. So far, the Universe is winning.', 'Rich Cook' ),
		array( 'There are two major products that come out of Berkeley: LSD and UNIX. We don’t believe this to be a coincidence.', 'Jeremy S. Anderson' ),
		array( 'Before software can be reusable it first has to be usable.', 'Ralph Johnson' ),
	);

	public function __construct() {
		parent::__construct(
			'wordsesh_quote',
			__( 'Random Quotes', 'wordsesh' ),
			array( 'description' => __( 'Display a random quote', 'wordsesh' ) )
		);

		$this->quotes = apply_filters( 'wordsesh_quotes', $this->quotes );

		add_action( 'wp_ajax_wordsesh_quote_refresh', array( $this, 'refresh' ) );
		add_action( 'wp_ajax_nopriv_wordsesh_quote_refresh', array( $this, 'refresh' ) );
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $args['before_widget'];
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		echo '<div id="wordsesh_quote">';
		echo $this->get_quote();
		echo '</div>';

		echo '<a id="wordsesh_quote_refresh" href="">' . __( "New quote", 'wordsesh' ) . '</a>';

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Random Quote', 'wordsesh' );
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

	public function get_quote() {
		$quote = $this->quotes[ rand( 0, count( $this->quotes ) ) ];

		$output = '<span class="quote">"' . esc_html( $quote[0] ) . '"</span>';
		$output .= '<span class="attribution">&mdash;' . esc_html( $quote[1] ) . '</span>';

		return $output;
	}

	public function refresh() {
		echo $this->get_quote();
		die();
	}
}