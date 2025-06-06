<?php
/**
 * Give this theme some additional widgets.
 *
 * @since 1.0
 *
 * @license GPL 2.0
 */
class Vantage_CircleIcon_Widget extends WP_Widget {
	public function __construct() {
		// widget actual processes
		parent::__construct(
			'circleicon-widget',
			__( 'Vantage Circle Icon', 'vantage' ),
			array( 'description' => __( 'An icon in a circle with some text beneath it', 'vantage' ) )
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'title_color' => '',
			'text' => '',
			'text_color' => '',
			'in_post_loop' => true,
			'icon' => '',
			'icon_color' => '',
			'image' => '',
			'icon_position' => 'top',
			'icon_size' => 'small',
			'icon_background_color' => '',
			'more' => '',
			'more_url' => '',
			'all_linkable' => false,
			'box' => false,
		) );

		$icon_styles = array();

		if ( ! empty( $instance['image'] ) ) {
			$icon_styles[] = 'background-image: url(' . esc_url( $instance['image'] ) . ')';
		}

		if ( ! empty( $instance['icon_background_color'] ) && preg_match( '/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', esc_attr( $instance['icon_background_color'] ) ) ) {
			$icon_styles[] = 'background-color: ' . esc_attr( $instance['icon_background_color'] );
		}

		if ( ! empty( $instance['title_color'] ) && preg_match( '/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $instance['title_color'] ) ) {
			$title_color = 'color: ' . esc_attr( $instance['title_color'] );
		}

		if ( ! empty( $instance['text_color'] ) && preg_match( '/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $instance['text_color'] ) ) {
			$text_color = 'color: ' . esc_attr( $instance['text_color'] );
		}

		if ( ! empty( $instance['icon_color'] ) && preg_match( '/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $instance['icon_color'] ) ) {
			$icon_color = 'style="color: ' . esc_attr( $instance['icon_color'] ) . '"';
		}

		$icon = $instance['icon'];

		if ( ! empty( $icon ) ) {
			$icon = apply_filters( 'vantage_fontawesome_icon_name', $icon );
		}

		$icon_styles = ! empty( $icon_styles ) ? 'style="' . implode( ';', $icon_styles ) . '"' : '';
		$icon_class = ! empty( $icon_styles ) ? ' icon-style-set' : '';
		$target = ( ! empty( $instance['more_target'] ) ? 'target="_blank"' : '' );

		wp_enqueue_style( 'social-media-widget' );
		?>
		<div class="circle-icon-box circle-icon-position-<?php echo esc_attr( $instance['icon_position'] ); ?> <?php echo empty( $instance['box'] ) ? 'circle-icon-hide-box' : 'circle-icon-show-box'; ?> circle-icon-size-<?php echo esc_attr( $instance['icon_size'] ); ?> <?php if ( siteorigin_setting( 'blog_featured_image_type' ) == 'none' ) {
			echo 'no-archive-featured-image';
		} ?>">
			<?php if ( ! empty( $instance['in_post_loop'] ) ) { ?>
				<div class="circle-icon-wrapper">
					<?php if ( ! empty( $instance['more_url'] ) && ! empty( $instance['all_linkable'] ) ) { ?>
					<a href="<?php echo esc_url( $instance['more_url'] ); ?>" class="link-icon" <?php echo $target; ?>><?php } ?>
					<div class="circle-icon<?php echo esc_attr( $icon_class ); ?>" <?php echo $icon_styles; ?>>
						<?php if ( ! empty( $icon ) ) { ?>
							<div class="<?php echo esc_attr( $icon );
							esc_attr( $icon_class ); ?>" <?php echo ! empty( $icon_color ) ? $icon_color : ''; ?>></div>
						<?php } ?>
					</div>
					<?php if ( ! empty( $instance['more_url'] ) && ! empty( $instance['all_linkable'] ) ) { ?></a><?php } ?>
				</div>
			<?php } ?>

			<?php if ( ! empty( $instance['more_url'] ) && ! empty( $instance['all_linkable'] ) ) { ?>
				<a href="<?php echo esc_url( $instance['more_url'] ); ?>" class="link-title" <?php echo $target; ?>>
			<?php } ?>
			<?php if ( ! empty( $instance['title'] ) ) { ?>
				<h4 <?php echo ! empty( $title_color ) ? 'style="' . esc_attr( $title_color ) . '"' : ''; ?>>
					<?php echo wp_kses_post( apply_filters( 'widget_title', $instance['title'] ) ); ?>
				</h4>
			<?php } ?>
			<?php if ( ! empty( $instance['more_url'] ) && ! empty( $instance['all_linkable'] ) ) { ?>
				</a>
			<?php } ?>

			<?php if ( ! empty( $instance['text'] ) ) { ?>
				<p class="text" <?php echo ! empty( $text_color ) ? 'style="' . esc_attr( $text_color ) . '"' : ''; ?>><?php echo wp_kses_post( $instance['text'] ); ?></p>
			<?php } ?>
			<?php if ( ! empty( $instance['more_url'] ) ) { ?>
				<a
					href="<?php echo esc_url( $instance['more_url'] ); ?>"
					class="more-button"
					<?php echo $target; ?>
					<?php echo ! empty( $text_color ) ? 'style="' . esc_attr( $text_color ) . '"' : ''; ?>
				>
					<?php echo ! empty( $instance['more'] ) ? esc_html( $instance['more'] ) : esc_html__( 'More Info', 'vantage' ); ?> <i></i>
				</a>
			<?php } ?>
		</div>
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Display the circle icon widget form.
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script(
			'vantage-color-picker',
			get_template_directory_uri() . '/js/color-picker.js',
			array( 'wp-color-picker' ),
			false,
			true
		);

		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'title_color' => '',
			'text' => '',
			'text_color' => '',
			'icon' => '',
			'icon_color' => '',
			'image' => '',
			'icon_position' => 'top',
			'icon_size' => 'small',
			'icon_background_color' => '',
			'more' => '',
			'more_url' => '',
			'all_linkable' => false,
			'more_target' => false,
			'box' => false,
		) );

		$icons = include get_template_directory() . '/fontawesome/icons.php';
		$sections = include get_template_directory() . '/fontawesome/icon-sections.php';

		if ( ! empty( $instance['icon'] ) ) {
			$instance['icon'] = apply_filters( 'vantage_fontawesome_icon_name', $instance['icon'] );
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'vantage' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title_color' ) ); ?>">
				<?php esc_html_e( 'Title Color', 'vantage' ); ?>
			</label><br>
			<input class="widefat vantage-color-field" id="<?php echo esc_attr( $this->get_field_id( 'title_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title_color' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title_color'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text', 'vantage' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" value="<?php echo esc_attr( $instance['text'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>">
				<?php esc_html_e( 'Text Color', 'vantage' ); ?>
			</label><br>
			<input class="widefat vantage-color-field" id="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_color' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['text_color'] ); ?>" />
		</p>

		<p>x
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon', 'vantage' ); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>">
				<option value="" <?php selected( ! empty( $instance['icon'] ) ); ?>><?php esc_html_e( 'None', 'vantage' ); ?></option>
				<?php foreach ( $icons as $section => $s_icons ) { ?>
					<?php if ( isset( $sections[ $section ] ) ) { ?><optgroup label="<?php echo esc_attr( $sections[ $section ] ); ?>"><?php } ?>
						<?php foreach ( $s_icons as $icon ) { ?>
							<option value="<?php echo esc_attr( $icon ); ?>" <?php selected( $instance['icon'], $icon ); ?>><?php echo esc_html( vantage_icon_get_name( $icon ) ); ?></option>
						<?php } ?>
					</optgroup>
				<?php } ?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>"><?php esc_html_e( 'Icon Color', 'vantage' ); ?></label><br>
			<input class="widefat vantage-color-field" id="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_color' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_color'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon_background_color' ) ); ?>"><?php esc_html_e( 'Icon Background Color', 'vantage' ); ?></label><br>
			<input class="widefat vantage-color-field" id="<?php echo esc_attr( $this->get_field_id( 'icon_background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_background_color' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['icon_background_color'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_html_e( 'Circle Background Image URL', 'vantage' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" value="<?php echo esc_attr( $instance['image'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>"><?php esc_html_e( 'Icon Position', 'vantage' ); ?></label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'icon_position' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_position' ) ); ?>">
				<option value="top" <?php selected( 'top', $instance['icon_position'] ); ?>><?php esc_html_e( 'Top', 'vantage' ); ?></option>
				<option value="bottom" <?php selected( 'bottom', $instance['icon_position'] ); ?>><?php esc_html_e( 'Bottom', 'vantage' ); ?></option>
				<option value="left" <?php selected( 'left', $instance['icon_position'] ); ?>><?php esc_html_e( 'Left', 'vantage' ); ?></option>
				<option value="right" <?php selected( 'right', $instance['icon_position'] ); ?>><?php esc_html_e( 'Right', 'vantage' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'icon_size' ) ); ?>">
				<?php esc_html_e( 'Icon Size', 'vantage' ); ?>
			</label><br>
			<select id="<?php echo esc_attr( $this->get_field_id( 'icon_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_size' ) ); ?>">
				<option value="small" <?php selected( 'small', $instance['icon_size'] ); ?>><?php esc_html_e( 'Small', 'vantage' ); ?></option>
				<option value="medium" <?php selected( 'medium', $instance['icon_size'] ); ?>><?php esc_html_e( 'Medium', 'vantage' ); ?></option>
				<option value="large" <?php selected( 'large', $instance['icon_size'] ); ?>><?php esc_html_e( 'Large', 'vantage' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more' ) ); ?>">
				<?php esc_html_e( 'More Text', 'vantage' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'more' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more' ) ); ?>" value="<?php echo esc_attr( $instance['more'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more_url' ) ); ?>">
				<?php esc_html_e( 'More URL', 'vantage' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'more_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_url' ) ); ?>" value="<?php echo esc_attr( $instance['more_url'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'all_linkable' ) ); ?>">
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'all_linkable' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'all_linkable' ) ); ?>" <?php checked( $instance['all_linkable'] ); ?> />
				<?php esc_html_e( 'Link title and icon to "More URL"', 'vantage' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more_target' ) ); ?>">
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'more_target' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_target' ) ); ?>" <?php checked( $instance['more_target'] ); ?> />
				<?php esc_html_e( 'Open link in a new tab', 'vantage' ); ?>
			</label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['box'] = ! empty( $new_instance['box'] );
		$new_instance['all_linkable'] = ! empty( $new_instance['all_linkable'] );
		$new_instance['more_target'] = ! empty( $new_instance['more_target'] );

		return $new_instance;
	}
}

class Vantage_Headline_Widget extends WP_Widget {
	public function __construct() {
		// widget actual processes
		parent::__construct(
			'headline-widget', // Base ID
			__( 'Vantage Headline', 'vantage' ), // Name
			array( 'description' => __( 'A lovely big headline.', 'vantage' ) ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		?>
		<h1><?php echo wp_kses_post( $instance['headline'] ); ?></h1>
		<div class="decoration"><div class="decoration-inside"></div></div>
		<h3><?php echo wp_kses_post( $instance['sub_headline'] ); ?></h3>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'headline' => '',
			'sub_headline' => '',
		) );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'headline' ) ); ?>">
				<?php esc_html_e( 'Headline', 'vantage' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'headline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'headline' ) ); ?>" value="<?php echo esc_attr( $instance['headline'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sub_headline' ) ); ?>">
				<?php esc_html_e( 'Sub Headline', 'vantage' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'sub_headline' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'sub_headline' ) ); ?>" value="<?php echo esc_attr( $instance['sub_headline'] ); ?>" />
		</p>
		<?php
	}
}

/**
 * A widget for display social media networks
 *
 * Class Vantage_Social_Media_Widget
 */
class Vantage_Social_Media_Widget extends WP_Widget {
	private $networks;

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'vantage-social-media',
			__( 'Vantage Social Media', 'vantage' ),
			array(
				'description' => __( 'Add nice little icons that link out to your social media profiles.', 'vantage' ),
			)
		);

		$this->networks = apply_filters( 'vantage_social_widget_networks', array(
			'facebook' => __( 'Facebook', 'vantage' ),
			'twitter' => __( 'X (Twitter)', 'vantage' ),
			'google-plus' => __( 'Google Plus', 'vantage' ),
			'linkedin' => __( 'LinkedIn', 'vantage' ),
			'dribbble' => __( 'Dribbble', 'vantage' ),
			'behance' => __( 'Behance', 'vantage' ),
			'deviantart' => __( 'DeviantArt', 'vantage' ),
			'flickr' => __( 'Flickr', 'vantage' ),
			'500px' => __( '500px', 'vantage' ),
			'instagram' => __( 'Instagram', 'vantage' ),
			'pinterest' => __( 'Pinterest', 'vantage' ),
			'skype' => __( 'Skype', 'vantage' ),
			'youtube' => __( 'YouTube', 'vantage' ),
			'vimeo' => __( 'Vimeo', 'vantage' ),
			'medium' => __( 'Medium', 'vantage' ),
			'tumblr' => __( 'Tumblr', 'vantage' ),
			'wordpress' => __( 'WordPress', 'vantage' ),
			'github' => __( 'GitHub', 'vantage' ),
			'bitbucket' => __( 'Bitbucket', 'vantage' ),
			'codepen' => __( 'Codepen', 'vantage' ),
			'mixcloud' => __( 'Mixcloud', 'vantage' ),
			'soundcloud' => __( 'SoundCloud', 'vantage' ),
			'stumbleupon' => __( 'StumbleUpon', 'vantage' ),
			'vk' => __( 'VK', 'vantage' ),
			'rss' => __( 'RSS', 'vantage' ),
			'envelope' => __( 'Email', 'vantage' ),
			'phone' => __( 'Phone', 'vantage' ),
		) );
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		foreach ( $this->networks as $id => $name ) {
			if ( ! empty( $instance[ $id ] ) ) {
				$instance[ $id ] = ( $id == 'envelope' && filter_var( $instance[ $id ], FILTER_VALIDATE_EMAIL ) ? 'mailto:' . $instance[ $id ] : $instance[ $id ] );
				$instance[ $id ] = ( $id == 'phone' && ! filter_var( $instance[ $id ], FILTER_VALIDATE_URL ) && strpos( $instance[ $id ], 'tel:' ) === false && strpos( $instance[ $id ], 'sms:' ) === false ? 'tel:' . $instance[ $id ] : $instance[ $id ] );
				$instance[ $id ] = ( $id == 'skype' && strpos( $instance[ $id ], 'skype:' ) === false && strpos( $instance[ $id ], 'callto:' ) === false ? 'skype:' . $instance[ $id ] : $instance[ $id ] );
				?><a class="social-media-icon social-media-icon-<?php echo $id; ?> social-media-icon-size-<?php echo esc_attr( $instance['size'] ); ?>" href="<?php echo esc_url( $instance[ $id ], array( 'http', 'https', 'mailto', 'skype', 'callto', 'tel', 'sms' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) . ' ' . $name ); ?>" <?php if ( ! empty( $instance['new_window'] ) ) {
					echo 'target="_blank"';
				} ?>><?php

				$icon = apply_filters( 'vantage_social_widget_icon_' . $id, '' );
				echo ! empty( $icon ) ? $icon : '<span class="fa fa-' . $id . '"></span>';

				?></a><?php
			}
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'size' => 'medium',
			'title' => '',
			'new_window' => false,
		) );

		$sizes = apply_filters( 'vantage_social_widget_sizes', array(
			'large' => __( 'Large', 'vantage' ),
			'medium' => __( 'Medium', 'vantage' ),
			'small' => __( 'Small', 'vantage' ),
		) );

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title', 'vantage' ); ?>
			</label><br/>
			<input type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>">
				<?php esc_html_e( 'Icon Size', 'vantage' ); ?>
			</label><br/>
			<select id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
				<?php foreach ( $sizes as $id => $name ) { ?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $instance['size'], $id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php } ?>
			</select>
		</p>

		<?php
		foreach ( $this->networks as $id => $name ) {
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>">
					<?php echo esc_html( $name ); ?>
				</label>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id( $id ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $id ) ); ?>" value="<?php echo esc_attr( ! empty( $instance[ $id ] ) ? $instance[ $id ] : '' ); ?>" class="widefat"/>
			</p>
			<?php
		}
		?>
		<p>
			<input type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'new_window' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>" <?php checked( $instance['new_window'] ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>">
				<?php esc_html_e( 'Open in New Window', 'vantage' ); ?>
			</label>
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['new_window'] = ! empty( $new_instance['new_window'] );

		return $new_instance;
	}
}

if ( ! function_exists( 'vantage_register_widgets' ) ) {
	/**
	 * Register the Vantage specific widgets.
	 */
	function vantage_register_widgets() {
		register_widget( 'Vantage_Social_Media_Widget' );
		register_widget( 'Vantage_CircleIcon_Widget' );
		register_widget( 'Vantage_Headline_Widget' );
	}
}
add_action( 'widgets_init', 'vantage_register_widgets' );

if ( ! function_exists( 'vantage_filter_carousel_loop' ) ) {
	/**
	 * Filter the carousel loop title to add navigation controls.
	 */
	function vantage_filter_carousel_loop( $title, $instance = array(), $id = false ) {
		if ( $id == 'siteorigin-panels-postloop' && isset( $instance['template'] ) && $instance['template'] == 'loops/loop-carousel.php' ) {
			$new_title = '<span class="vantage-carousel-title"><span class="vantage-carousel-title-text">' . $title . '</span>';
			$new_title .= '<a href="#" class="next" title="' . esc_attr( __( 'Next', 'vantage' ) ) . '"><span class="vantage-icon-arrow-right"></span></a>';
			$new_title .= '<a href="#" class="previous" title="' . esc_attr( __( 'Previous', 'vantage' ) ) . '"><span class="vantage-icon-arrow-left"></span></a>';
			$new_title .= '</span>';
			$title = $new_title;
		}

		return $title;
	}
}
add_filter( 'widget_title', 'vantage_filter_carousel_loop', 10, 3 );

if ( ! function_exists( 'vantage_carousel_ajax_handler' ) ) {
	/**
	 * Handle ajax requests for the carousel.
	 */
	function vantage_carousel_ajax_handler() {
		if ( empty( $_GET['query'] ) ) {
			return;
		}

		$query = $_GET['query'];
		$query['paged'] = $_GET['paged'];
		$query['post_status'] = 'publish';

		$query = new WP_Query( $query );

		ob_start();
		?>
		<div class="vantage-carousel-wrapper">
			<?php $vars = vantage_get_query_variables(); ?>

			<ul class="vantage-carousel" data-query="<?php echo esc_attr( json_encode( $vars ) ); ?>" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<?php while ( $query->have_posts() ) {
					$query->the_post(); ?>
					<li class="carousel-entry">
						<div class="thumbnail">
							<?php if ( has_post_thumbnail() ) {
								$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'vantage-carousel' ); ?>
								<a href="<?php the_permalink(); ?>" style="background-image: url(<?php echo esc_url( $img[0] ); ?>)">
								</a>
							<?php } else { ?>
								<a href="<?php the_permalink(); ?>" class="default-thumbnail"><span class="vantage-overlay"></span></a>
							<?php } ?>
						</div>
						<?php
						$title = get_the_title();

					if ( empty( $title ) ) {
						$title = __( 'Post ', 'vantage' ) . get_the_ID();
					} ?>
						<h3><a href="<?php esc_url( get_the_permalink() ); ?>"><?php echo esc_html( $title ); ?></a></h3>
					</li>
				<?php } ?>
			</ul>
		</div>
		<?php

		// Reset everything
		wp_reset_postdata();

		header( 'content-type:application/json' );
		echo wp_json_encode( array(
			'html' => ob_get_clean(),
			'count' => $query->post_count,
		) );

		exit();
	}
}
add_action( 'wp_ajax_vantage_carousel_load', 'vantage_carousel_ajax_handler' );
add_action( 'wp_ajax_nopriv_vantage_carousel_load', 'vantage_carousel_ajax_handler' );

function vantage_lazy_load_exclude_header( $index ) {
	if ( $index == 'sidebar-header' ) {
		add_filter( 'siteorigin_widgets_image_lazy_load', '__return_false', 15 );
	}
}
add_action( 'dynamic_sidebar_before', 'vantage_lazy_load_exclude_header' );

function vantage_restore_lazy_load( $index ) {
	if ( $index == 'sidebar-header' ) {
		remove_filter( 'siteorigin_widgets_image_lazy_load', '__return_false', 15 );
	}
}
add_action( 'dynamic_sidebar_after', 'vantage_restore_lazy_load' );
