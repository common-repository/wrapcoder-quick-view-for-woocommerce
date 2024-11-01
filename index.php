<?php
/**
* Plugin Name: Quick View for WooCommerce
* Plugin URI: http://4msar.wordpress.com
* Author: MSAR
* Version: 1.0
* Text Domain: wrapcoder-quick-view
* Domain Path: /languages
* Author URI: http://fb.com/4msar
* Description: WooCommerce Quick View Enables customer to have a quick look of product without visiting product page.
* Tags: free quick view, modal, product summary, products quick view, quick-view, single product, summary, woocommerce, woocommerce extension, WooCommerce Plugin,WooCommerce quickview , WooCommerce Lightbox , WooCommerce quick view , Woocommerce fast view , Quick View , Lightbox
*/

//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}




/**
 * Localisation
 */
load_plugin_textdomain( 'wrapcoder-quick-view', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


//WooCommerce Activation & Mobile device check
if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option('active_plugins'))) || class_exists( 'WooCommerce' )){
	/**
	 * Quick View Core File
	 */
	include_once('inc/wc-quick-view.php');
	include_once('inc/wc-qv-admin.php');

	/**
	 * Style & Scripts
	 */
	function product_quick_view_scripts() {	
			wp_enqueue_style('wrapcoder-qv-style',plugins_url('/assets/wc-qv-style.css',__FILE__),null,'1.7');
			wp_enqueue_script('wrapcoder-qv-js',plugins_url('/assets/wc-qv-script.js',__FILE__),array('jquery'),'1.7',true);
		}
	add_action( 'wp_enqueue_scripts', 'product_quick_view_scripts' );

}
else{
	add_action( 'admin_notices', 'wrapcoder_admin_notices' );
}

/**
 * WooCommerce not activated error.
 */
function wrapcoder_admin_notices(){
	?>
    <div class="notice notice-error">
        <p><?php _e( 'Without WooCommerce this Plugin is not work properly, so Install WooCommerce Plugin First.', 'sample-text-domain' ); ?></p>
    </div>
    <?php
}

