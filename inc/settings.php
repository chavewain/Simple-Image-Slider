<?php



function load_custom_wp_admin_slide_assets(){
    
    wp_enqueue_style( 'highlightn_css',  plugin_dir_url( __FILE__ ) . 'switch/css/highlight.css' );
    wp_enqueue_style( 'bootstrap-switch_css',  plugin_dir_url( __FILE__ ) . 'switch/css/bootstrap-switch.css' );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap-js', plugin_dir_url( __FILE__ ) . 'switch/js/bootstrap.min.js', array(), '3.0.3', true );
    wp_enqueue_script( 'highlight-js', plugin_dir_url( __FILE__ ) . 'switch/js/highlight.js', array(), '3.0.3', true );
    wp_enqueue_script( 'bootstrap-switch-js', plugin_dir_url( __FILE__ ) . 'switch/js/bootstrap-switch.js', array(), '3.0.3', true );
    wp_enqueue_script( 'main-js', plugin_dir_url( __FILE__ ) . 'switch/js/main.js', array(), '3.0.3', true );
}

add_action('admin_enqueue_scripts', 'load_custom_wp_admin_slide_assets');


// create custom plugin settings menu
add_action('admin_menu', 'my_cool_plugin_create_menu');

function my_cool_plugin_create_menu() {

	//create new top-level menu
	//add_menu_page('My Cool Plugin Settings', 'Cool Settings', 'administrator', __FILE__, 'my_cool_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );
	add_submenu_page('edit.php?post_type=slide', 'Custom Post Type Admin', 'Settings', 'edit_posts', basename(__FILE__), 'my_cool_plugin_settings_page');
	//call register settings function
	add_action( 'admin_init', 'register_my_cool_plugin_settings' );
}


function register_my_cool_plugin_settings() {
	//register our settings
	register_setting( 'my-cool-plugin-settings-group', 'autoslide' );
	register_setting( 'my-cool-plugin-settings-group', 'timeout' );
	register_setting( 'my-cool-plugin-settings-group', 'pausehover' );
}

function my_cool_plugin_settings_page() {
?>
<div class="wrap slide-plugon-settings">
<h2>Plugin Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'my-cool-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'my-cool-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Auto Slide</th>
        <td><input name="autoslide" id="switch-offColor" type="checkbox" data-off-color="warning" value="1" <?php if(esc_attr( get_option('autoslide') )) echo "checked"; ?>></td>
        </tr>
         
        <tr valign="top">
        <th scope="row">Millisecconds Delay</th>
        <td><input type="text" name="timeout" value="<?php echo esc_attr( get_option('timeout') ); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Pause on Hover</th>
        <td><input name="pausehover" id="switch-offColor" type="checkbox" data-off-color="warning" value="1" <?php if(esc_attr( get_option('pausehover') )) echo "checked"; ?>></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>

<!-- Desarrollado por Dionisio Chavez para FUNGLODE -->

<?php } ?>