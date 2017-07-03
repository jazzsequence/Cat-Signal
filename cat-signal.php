<?php
/*
Plugin Name: Cat Signal
Plugin URI: http://jazzsequence.github.io/Cat-Signal
Description: A WordPress plugin to easily display a banner or a modal alert when the Cat Signal (from the Internet Defense League) is active. For more information visit: http://internetdefenseleague.org/
Version: 1.1.2
Author: Chris Reynolds
Author URI: http://chrisreynolds.io
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
*/

define( 'CAT_SIGNAL_PATH', plugin_dir_path(__FILE__) );
define( 'CAT_SIGNAL_PLUGIN_URL', plugin_dir_url(__FILE__) );
$cat_signal_options = get_option( 'cat_signal' );

function idl_cats_in_yr_wp() {
	global $cat_signal_options;
	// do html stuff
	?>
		<div class="wrap">
			<?php screen_icon('cat-signal'); ?>
			<h2><?php _e( 'Internet Defense League &mdash; Cat Signal', 'cat-signal' ); ?></h2>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'cat_signal_options' );
				?>
				<table class="form-table">
					<tbody>
						<?php idl_do_signal_type_selection(); ?>
					</tbody>
				</table>
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
				<input type="hidden" name="ap-core-settings-submit" value="Y" />
			</form>
			<div style="width: 100%; text-align: center; margin-top: 20px;">
				<a href="http://internetdefenseleague.org/" target="_blank"><img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>/img/IDL_type_logo.png" alt="<?php _e('The Internet Defense League', 'cat-signal'); ?>" /></a>
			</div>
		</div>
	<?php
}

function idl_cats_in_yr_menus() {
	add_submenu_page( 'options-general.php', __('Cat Signal', 'cat-signal'), __('Cat Signal', 'cat-signal'), 'administrator', 'cat_signal', 'idl_cats_in_yr_wp' );
}
add_action( 'admin_menu', 'idl_cats_in_yr_menus' );

function idl_initialize_cats() {
	register_setting( 'cat_signal_options', 'cat_signal', 'idl_validate_teh_cats' );
}
add_action( 'admin_init', 'idl_initialize_cats' );

function idl_do_signal_type_selection() {
	global $cat_signal_options;
	ob_start();
	?>
		<tr valign="top"><th scope="row"><?php _e( 'Type of signal', 'cat-signal' ); ?></th>
			<td>
				<select id="cat-breed" name="cat_signal[type]">
				<?php
					$selected = $cat_signal_options['type'];
					foreach ( idl_all_the_cats() as $option ) {
						$label = $option['label'];
						$value = $option['value'];
						echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
					}
				?>
				</select>
				<p>
					<label type="description" for="cat_signal[type]"><small>
						<?php _e( 'If Stop the Secrecy option is selected, the modal Cat Signal will be selected for any other campaigns and a Stop the Secrecy widget will appear on your <a href="widgets.php">Widgets</a> page. <strong>Important Note:</strong> The dimensions of this widget/petition cannot be changed. This means that the widget might not look good on all themes. If this is the case for you, you can <a href="https://openmedia.org/stopthesecrecy/resources">get the code</a> and add it somewhere else on your site.', 'cat-signal' ); ?>
					</small></label>
				</p>
			</td>
		</tr>
		<tr valign="top"><th scope="row"><?php _e( 'Where should the Cat Signal display?', 'cat-signal' ); ?></th>
			<td>
				<select id="cat-location" name="cat_signal[location]">
				<?php
					if ( $cat_signal_options['location-other'] ) {
						$cat_signal_options['location-other'] = wp_kses($cat_signal_options['location-other']);
					} else {
						$cat_signal_options['location-other'] = '';
					}
					$selected = $cat_signal_options['location'];
					foreach ( idl_whar_is_cats() as $option ) {
						$label = $option['label'];
						$value = $option['value'];
						echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
					}
				?>
				</select>
				<p><?php _e( 'Other', 'cat-signal' ); ?>: <input type="text" id="cat-other-location" name="cat_signal[location-other]" width="15" value="<?php echo $cat_signal_options['location-other']; ?>" /><br />
				<label class="description" for="cat_signal[location]"><small><?php _e( 'This controls where the alert (banner or modal) will display on your site. If you want to display it on all pages, use the "All pages" option. If you only want to display it on the home page (whether that\'s a static page or your main blog page), select Home/Front Page. If you\'d rather set a specific page, enter either the page ID or the page slug into the "Other" box and select "Other" from the dropdown.', 'cat-signal' ); ?></small></label></p>
			</td>
		<tr valign="top"><th scope="row"><?php _e( 'Screenshots', 'cat-signal' ); ?></th>
			<td>
				<div class="alignleft" style="margin-right: 20px;">
					<img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/banner.png" alt="<?php _e( 'Banner', 'cat-signal' ); ?>" />
					<p><?php _e( 'Banner', 'cat-signal' ); ?></p>
				</div>
				<div class="alignleft" style="margin-right: 20px;">
					<img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/modal.png" alt="<?php _e( 'Modal', 'cat-signal' ); ?>" />
					<p><?php _e( 'Modal', 'cat-signal' ); ?></p>
				</div>
				<!--<div class="alignleft">
					<img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/StopSecrecy.png" alt="<?php _e( 'Stop the Secrecy petition' ); ?>" />
					<p><?php _e( 'Stop the Secrecy petition' ); ?></p>
				</div>-->
			</td>
		</tr>
		<!-- <tr valign="top"><th scope="row"><?php _e('Test it!', 'cat-signal'); ?></th>
			<td>
				<?php
					$message = '';
					if ( $cat_signal_options['location'] == 'all' || $cat_signal_options['location'] == 'front' || ( $cat_signal_options['location'] == 'other' && !$cat_signal_options['location-other'] ) ) {
						$url = home_url() . '?_idl_test=1';
					} elseif ( $cat_signal_options['location'] == 'other' && $cat_signal_options['location-other'] ) {
						if ( is_numeric( $cat_signal_options['location-other'] ) ) {
							$url = home_url() . '?p=' . $cat_signal_options['location-other'] . '&_idl_test=1';
						} else {
							$url = home_url() . '/' . $cat_signal_options['location-other'] . '?_idl_test=1';
						}
					} else {
						$url = null;
						$message = __( 'Woah there! I couldn\'t figure out what page you are loading your script on. Try saving your options again.', 'cat-signal' );
					}
					if ( $url ) {
						echo sprintf( __( '%sRun the test on your site.%s', 'cat-signal' ), '<a href="' . $url . '" target="_blank">', '</a>' );
					} else {
						echo $message;
					}
				?>
				<br />
				<label class="description" for="cat_signal[test]"><small><?php _e( 'This will add a test parameter at the end of the URL to the page (or pages) that you have set to display the alert to make sure it\'s working correctly. If, for some reason, this link doesn\'t work, you can run the test manually by adding <code>?_idl_test=1</code> to the end of your url.', 'cat-signal' ); ?></small></label>
			</td> -->
	<?php
	$cat_settings = ob_get_contents();
	ob_end_clean();
	echo $cat_settings;
}

function idl_all_the_cats() {
	$cat_breeds = array(
		/*'special' => array(
			'value' => 'special',
			'label' => __( 'Stop the Secrecy', 'cat-signal' )
		),*/
		'banner' => array(
			'value' => 'banner',
			'label' => __( 'Banner', 'cat-signal' )
		),
		'modal' => array(
			'value' => 'modal',
			'label' => __( 'Modal', 'cat-signal' )
		)
	);
	return $cat_breeds;
}

function idl_whar_is_cats() {
	$cat_locations = array(
		'all' => array(
			'value' => 'all',
			'label' => __( 'All pages', 'cat-signal' )
		),
		'front' => array(
			'value' => 'front',
			'label' => __( 'Home/Front Page', 'cat-signal' )
		),
		'other' => array(
			'value' => 'other',
			'label' => __( 'Other page', 'cat-signal' )
		)
	);
	return $cat_locations;
}

function idl_signal_all_the_cats() {
	global $cat_signal_options;
	switch( $cat_signal_options['location'] ) {
		case 'all':
			idl_all_the_cats_all_lined_up();
			break;
		case 'front':
			if ( is_front_page() || is_home() ) {
				idl_all_the_cats_all_lined_up();
			}
			break;
		case 'other':
			if ( $cat_signal_options['location-other'] ) {
				if ( is_page( $cat_signal_options['location-other'] ) ) {
					idl_all_the_cats_all_lined_up();
				}
			} else {
				idl_all_the_cats_all_lined_up();
			}
			break;
		default:
			idl_all_the_cats_all_lined_up();
	}

}
add_action( 'wp_head', 'idl_signal_all_the_cats' );

function idl_all_the_cats_all_lined_up() {
	global $cat_signal_options;
	if ( !is_admin() ) {
		if ( $cat_signal_options['type'] == 'banner' ) {
			wp_enqueue_script( 'idf-banner', CAT_SIGNAL_PLUGIN_URL . 'js/banner.js', array(), '1.0', false );
		/*} elseif ( $cat_signal_options['type'] == 'special' ) { // used for special, one-time campaigns
			$code = '';
			printf( $code );*/
		} else {
			// if nothing has been set, default to modal.
			wp_enqueue_script( 'idf-modal', CAT_SIGNAL_PLUGIN_URL . 'js/modal.js', array(), '1.0', false );
		}
	}
}

function idl_cat_icon() {
    ?>
    <style type="text/css" media="screen">
        #icon-cat-signal {
            background: url(<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/icon32.png) no-repeat!important;
        }
    </style>
<?php
}
add_action( 'admin_head', 'idl_cat_icon' );

function idl_validate_teh_cats($input) {
	if ( !array_key_exists( $input['type'], idl_all_the_cats() ) )
		$input['type'] = null;
	if ( !array_key_exists( $input['location'], idl_whar_is_cats() ) )
		$input['location'] = null;
	$input['location-other'] = wp_filter_nohtml_kses( $input['location-other'] );

	return $input;
}

// added for stop the secrecy campaign widget
if ( $cat_signal_options['type'] == 'special' ) {
	add_action( 'widgets_init', 'idl_widgetize_teh_cats');
}

function idl_widgetize_teh_cats() {
	register_widget( 'Cat_Signal_Widget' );
}

class Cat_Signal_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'cat_signal_widget',
			__( 'Stop the Secrecy Widget', 'cat-signal' ),
			array( 'description' => __( 'Displays the Stop the Secrecy petition in a widget.', 'cat-signal' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		$code = '<script type="text/javascript"> widgetContext = {"url":"https:\u002F\u002Fopenmedia.org\u002Fwidgets\u002Fstop-secrecy?width=260\u0026height=460\u0026src=aux", "width":"260", "height":"705", "widgetid":"web_widget_iframe_9c82eae7a4902042e4b47b5c826fa5e6", "scrolling":"auto"}; </script><script id="web_widget_iframe_9c82eae7a4902042e4b47b5c826fa5e6" src="https://openmedia.org/sites/all/modules/contrib/web_widgets/iframe/web_widgets_iframe.js"></script>';

		echo $args['before_widget'];
		if ( !empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		echo $code;

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = '';
		}
		// form is here
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}