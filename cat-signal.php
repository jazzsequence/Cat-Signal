<?php
/*
Plugin Name: Cat Signal
Plugin URI: http://jazzsequence.github.io/Cat-Signal
Description: A WordPress plugin to easily display a banner or a modal alert when the Cat Signal (from the Internet Defense League) is active. For more information visit: http://internetdefenseleague.org/
Version: 1.0.7
Author: Chris Reynolds
Author URI: http://chrisreynolds.io
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
*/

define( 'CAT_SIGNAL_PATH', plugin_dir_path(__FILE__) );
define( 'CAT_SIGNAL_PLUGIN_URL', plugin_dir_url(__FILE__) );

function idl_cats_in_yr_wp() {
	// do html stuff
	?>
		<div class="wrap">
			<?php screen_icon('cat-signal'); ?>
			<h2><?php _e( 'Internet Defense League &mdash; Cat Signal', 'cat-signal' ); ?></h2>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'cat_signal_options' );
					$options = get_option('cat_signal');
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
	$options = get_option( 'cat_signal' );
	ob_start();
	?>
		<tr valign="top"><th scope="row"><?php _e( 'Type of signal', 'cat-signal' ); ?></th>
			<td>
				<select id="cat-breed" name="cat_signal[type]">
				<?php
					$selected = $options['type'];
					foreach ( idl_all_the_cats() as $option ) {
						$label = $option['label'];
						$value = $option['value'];
						echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
					}
				?>
				</select>
			</td>
		</tr>
		<tr valign="top"><th scope="row"><?php _e( 'Where should the Cat Signal display?', 'cat-signal' ); ?></th>
			<td>
				<select id="cat-location" name="cat_signal[location]">
				<?php
					if ( $options['location-other'] ) {
						$options['location-other'] = wp_kses($options['location-other']);
					} else {
						$options['location-other'] = '';
					}
					$selected = $options['location'];
					foreach ( idl_whar_is_cats() as $option ) {
						$label = $option['label'];
						$value = $option['value'];
						echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . esc_attr($label) . '</option>';
					}
				?>
				</select>
				<p><?php _e( 'Other', 'cat-signal' ); ?>: <input type="text" id="cat-other-location" name="cat_signal[location-other]" width="15" value="<?php echo $options['location-other']; ?>" /><br />
				<label class="description" for="cat_signal[location]"><?php _e( 'This controls where the alert (banner or modal) will display on your site. If you want to display it on all pages, use the "All pages" option. If you only want to display it on the home page (whether that\'s a static page or your main blog page), select Home/Front Page. If you\'d rather set a specific page, enter either the page ID or the page slug into the "Other" box and select "Other" from the dropdown.', 'cat-signal' ); ?></label></p>
			</td>
		<tr valign="top"><th scope="row"><?php _e( 'Screenshots', 'cat-signal' ); ?></th>
			<td>
				<div class="alignleft" style="margin-right: 20px;">
					<img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/banner.png" alt="<?php _e( 'Banner', 'cat-signal' ); ?>" />
					<p><?php _e( 'Banner', 'cat-signal' ); ?></p>
				</div>
				<div class="alignleft">
					<img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/modal.png" alt="<?php _e( 'Modal', 'cat-signal' ); ?>" />
					<p><?php _e( 'Modal', 'cat-signal' ); ?></p>
				</div>
			</td>
		</tr>
		<tr valign="top"><th scope="row"><?php _e('Test it!', 'cat-signal'); ?></th>
			<td>
				<?php
					$message = '';
					if ( $options['location'] == 'all' || $options['location'] == 'front' || ( $options['location'] == 'other' && !$options['location-other'] ) ) {
						$url = home_url() . '?_idl_test=1';
					} elseif ( $options['location'] == 'other' && $options['location-other'] ) {
						if ( is_numeric( $options['location-other'] ) ) {
							$url = home_url() . '?p=' . $options['location-other'] . '&_idl_test=1';
						} else {
							$url = home_url() . '/' . $options['location-other'] . '?_idl_test=1';
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
				<label class="description" for="cat_signal[test]"><?php _e( 'This will add a test parameter at the end of the URL to the page (or pages) that you have set to display the alert to make sure it\'s working correctly. If, for some reason, this link doesn\'t work, you can run the test manually by adding <code>?_idl_test=1</code> to the end of your url.', 'cat-signal' ); ?></label>
	<?php
	$cat_settings = ob_get_contents();
	ob_end_clean();
	echo $cat_settings;
}

function idl_all_the_cats() {
	$cat_breeds = array(
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
	$options = get_option( 'cat_signal' );
	switch( $options['location'] ) {
		case 'all':
			idl_all_the_cats_all_lined_up();
			break;
		case 'front':
			if ( is_front_page() || is_home() ) {
				idl_all_the_cats_all_lined_up();
			}
			break;
		case 'other':
			if ( $options['location-other'] ) {
				if ( is_page( $options['location-other'] ) ) {
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
	$options = get_option( 'cat_signal' );
	if ( !is_admin() ) {
		if ( $options['type'] == 'banner' ) {
			wp_enqueue_script( 'idf-banner', CAT_SIGNAL_PLUGIN_URL . 'js/banner.js', array(), '1.0', false );
		} elseif ( $options['type'] == 'modal' ) {
			wp_enqueue_script( 'idf-modal', CAT_SIGNAL_PLUGIN_URL . 'js/modal.js', array(), '1.0', false );
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