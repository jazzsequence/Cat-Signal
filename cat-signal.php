<?php
/*
Plugin Name: Cat Signal
Plugin URI: https://github.com/jazzsequence/Cat-Signal
Description: A WordPress plugin to easily display a banner or a modal alert when the Cat Signal (from the Internet Defense League) is active. For more information visit: http://internetdefenseleague.org/
Version: 1.0.1
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
				<a href="http://internetdefenseleague.org/" target="_blank"><img src="http://internetdefenseleague.org/images/vector/IDL_type_logo.png" alt="<?php _e('The Internet Defense League', 'cat-signal'); ?>" /></a>
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
		<tr valign="top"><th scope="row"><?php _e( 'Screenshots', 'cat-signal' ); ?></th>
			<td>
				<div class="alignleft" style="margin-right: 20px;">
					<img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/banner.png" alt="<?php _e( 'Banner', 'cat-signal' ); ?>" />
					<p><?php _e( 'Banner', 'cat-signal' ); ?></p>
				</div>
				<div class="alignleft">
					<img src="<?php echo CAT_SIGNAL_PLUGIN_URL; ?>img/modal.png" alt="<?php _e( 'Modal', 'cat-signal' ); ?>" />
					<p><?php _e( 'Modal', 'cat-signal' ); ?></p>
			</td>
		</tr>
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

function idl_signal_all_the_cats() {
	$options = get_option( 'cat_signal' );
	if ( !is_admin() ) {
		if ( $options['type'] == 'banner' ) {
			wp_enqueue_script( 'idf-banner', CAT_SIGNAL_PLUGIN_URL . 'js/banner.js', array(), '1.0', false );
		} elseif ( $options['type'] == 'modal' ) {
			wp_enqueue_script( 'idf-modal', CAT_SIGNAL_PLUGIN_URL . 'js/modal.js', array(), '1.0', false );
		} else {
			die();
		}
	}
}
add_action( 'wp_head', 'idl_signal_all_the_cats' );

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
	if ( !array_key_exists( $input['type'], array('banner','modal') ) )
		$input['type'] = $input['type'];

	return $input;
}