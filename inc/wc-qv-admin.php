<?php
//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}


add_action( 'admin_enqueue_scripts', 'add_color_picker' );
function add_color_picker( $hook ) {
 
    if( is_admin() ) { 
     
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'custom-script-handle', plugins_url( 'admin-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    }
}


add_action('admin_menu', 'register_wc_quickview');

function register_wc_quickview() {
    add_submenu_page( 
    	'woocommerce', 
    	'WC QuickView', 
    	'WC QuickView', 
    	'manage_options', 
    	'wrapcoder-quickview', 
    	'wrapcoder_quickview_callback' ); 
    
}

function wrapcoder_quickview_callback() { ?>
	<?php settings_errors(); ?>
	<form class="wc-qv-form" method="post" action="options.php">
    <?php
		settings_fields("wrapcoder_section");

		do_settings_sections("wrapcoder_qv");
		 
		submit_button(); 
    ?>
    </form>
<?php }

/*******************************************************/
function wrapcoder_settings_page()
{
    add_settings_section("wrapcoder_section", "WC QuickView Settings", null, "wrapcoder_qv");
    
    // Enable Quick View
    add_settings_field("wrapcoder-qv-checkbox", "Enable QuickView", "wrapcoder_checkbox_display", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-checkbox");
    // Button Text
    add_settings_field("wrapcoder-qv-btn-name", "QuickView Button Text", "wrapcoder_text_display", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-text");
    // Button Position
	add_settings_field('wrapcoder-qv-btn-pos', 'Select Position', 'setting_dropdown_fn', 'wrapcoder_qv', 'wrapcoder_section');
    register_setting("wrapcoder_section", "qv-btn-pos");
    // Button Background
    add_settings_field("wrapcoder-qv-btn-bg", "Button Background", "wrapcoder_btn_bg", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-bg");
    // Button Background on Hover
    add_settings_field("wrapcoder-qv-btn-bg-hover", "Button Background on Hover", "wrapcoder_btn_bg_hover", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-bg-hover");
    // Button Text Color
    add_settings_field("wrapcoder-qv-btn-txt", "Button Text Color", "wrapcoder_btn_txt", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-txt");
    // Button Text Color on Hover
    add_settings_field("wrapcoder-qv-btn-txt-hover", "Button Text Color on Hover", "wrapcoder_btn_txt_hover", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-txt-hover");
    // Button Text Size
    add_settings_field("wrapcoder-qv-btn-txt-size", "Button Text Size", "wrapcoder_btn_txt_size", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-txt-size");
    // Button Padding
    add_settings_field("wrapcoder-qv-btn-txt-padding", "Button Text Padding", "wrapcoder_btn_txt_padding", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-txt-padding");
    // Button Border Radius
    add_settings_field("wrapcoder-qv-btn-br", "Button Border Radius", "wrapcoder_btn_border_radius", "wrapcoder_qv", "wrapcoder_section");  
    register_setting("wrapcoder_section", "qv-btn-br");

}

function wrapcoder_checkbox_display() { ?>
        <input type="checkbox" name="qv-checkbox" value="1" <?php checked(1, get_option('qv-checkbox'), true); ?> /> 
    <span class="description">Enable or Disable QuickView Functionality</span>
   <?php
}
function wrapcoder_text_display() { ?>
    <input type="text" name="qv-btn-text" value="<?php echo get_option('qv-btn-text','QuickView'); ?>" /> 
    <span class="description">Button Text (Display on Front)</span>
   <?php 
}
function wrapcoder_btn_bg() { ?>
    <input type="text" class="color-field" name="qv-btn-bg" value="<?php echo get_option('qv-btn-bg', '#2949cc'); ?>" >
    <span class="description">Button Background Color </span>
   <?php 
}
function wrapcoder_btn_bg_hover() { ?>
    <input type="text" class="color-field" name="qv-btn-bg-hover" value="<?php echo get_option('qv-btn-bg-hover','#172b75'); ?>" >
    <span class="description">Button Background Color on Hover</span>
   <?php 
}
function wrapcoder_btn_txt() { ?>
    <input type="text" class="color-field" name="qv-btn-txt" value="<?php echo get_option('qv-btn-txt','#fff'); ?>" >
    <span class="description">Button Text Color </span>
   <?php 
}
function wrapcoder_btn_txt_hover() { ?>
    <input type="text" class="color-field" name="qv-btn-txt-hover" value="<?php echo get_option('qv-btn-txt-hover','#fff'); ?>" >
    <span class="description">Button Text Color on Hover</span>
   <?php 
}
function wrapcoder_btn_txt_size() { ?>
    <input type="text" placeholder="Add Text Size(px,em,pt)" class="" name="qv-btn-txt-size" value="<?php echo get_option('qv-btn-txt-size','16px'); ?>" >
    <span class="description">Button Font Size use px, em or pt</span>
   <?php 
}
function wrapcoder_btn_txt_padding() { ?>
    <input type="text" placeholder="Add Padding (px,em,pt)" class="" name="qv-btn-txt-padding" value="<?php echo get_option('qv-btn-txt-padding','3px'); ?>" >
    <span class="description">Button Padding use px, em or pt</span>
   <?php 
}
function wrapcoder_btn_border_radius() { ?>
    <input type="text" placeholder="Button Border Radius (px,em,pt)" class="" name="qv-btn-br" value="<?php echo get_option('qv-btn-br','2px'); ?>" >
    <span class="description">Button Border radius use px, em or pt</span>
   <?php 
}
// DROP-DOWN-BOX - Name: plugin_options[dropdown1]
function  setting_dropdown_fn() { ?>
<select name="qv-btn-pos">
    <option value="hover" <?php if(get_option('qv-btn-pos')=='hover') { echo 'selected="selected"'; } ?>>Show on Hover</option>
    <option value="fixed" <?php if(get_option('qv-btn-pos')=='fixed') { echo 'selected="selected"'; } ?>>Show Simple</option>
</select>
    <span class="description">Button Position</span>
<?php 
}
///////////
add_action("admin_init", "wrapcoder_settings_page");
/*******************************************************/
