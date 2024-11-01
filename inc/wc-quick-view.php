<?php
//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}
/******************************************************************************/
/* WooCommerce Product Quick View *********************************************/
/******************************************************************************/

	// Load The Product

	function product_quick_view_fn() {
		if (!isset( $_REQUEST['product_id'])) {
			die();
		}
		$product_id = intval($_REQUEST['product_id']);
		$i_next 	= (int) $_GET['next'];
		$i_prev 	= (int) $_GET['prev'];
		// wp_query for the product
		wp('p='.$product_id.'&post_type=product');
		ob_start();
		include_once 'wc-quick-view-template.php';
		echo ob_get_clean();
		die();
	}	
	add_action( 'wp_ajax_product_quick_view', 'product_quick_view_fn');
	add_action( 'wp_ajax_nopriv_product_quick_view', 'product_quick_view_fn');

	
	// Show Quick View Button

	function product_quick_view_button() {
		global $product;
		$quick_view = get_option('qv-checkbox');
		$qv_txt = get_option('qv-btn-text', 'QuickView');
		if (isset($quick_view) && ($quick_view == 1) ){
			echo '<a href="#" id="product_id_' . $product->get_id() . '" class="product_quick_view_button button" data-product_id="' . $product->get_id() . '">' . __( $qv_txt , 'wrapshop') . '<i class="ws-qvb" id=qv_icon_id_' . $product->get_id() . '"></i></a>';
		}
	}
	// run the action 
	//woocommerce_after_shop_loop_item_title
	add_action( 'woocommerce_after_shop_loop_item', 'product_quick_view_button', 10 );


if (get_option('qv-checkbox')==true) {
	# code...
	add_action( 'wp_head', 'wrapshop_style' );
	add_action( 'wp_footer', 'wrapshop_ajaxurl' );
	add_action( 'wp_footer', 'wrapshop_quickview' );
}


if ( ! function_exists( 'wrapshop_ajaxurl' )) {
	/**
	 * Wrap Shop Ajax url for Javascript
	 * Hooked into the `header`
	 *
	 * @since 1.0
	 * @return style
	 */
	function wrapshop_style() {
		$btn_color = get_option('qv-btn-txt','#fff');
		$btn_color_hov = get_option('qv-btn-txt-hover','#fff');
		$btn_bg_color = empty(get_option('qv-btn-bg')) ? '#2949cc' : get_option('qv-btn-bg','#f9ba00');
		$btn_bg_color_hov = get_option('qv-btn-bg-hover','#bf8f00');

	?>
	<style type="text/css">
	<?php if(get_option('qv-btn-pos')=='hover') {  ?>


	/**
	 *Quick View Button 
	**/
	.woocommerce .product_quick_view_button{
		color: <?php echo $btn_color; ?> !important;
	    background-color: <?php echo $btn_bg_color; ?> !important;
		padding: <?php echo get_option('qv-btn-txt-padding',2); ?> !important;
		font-size: <?php echo get_option('qv-btn-txt-size',16); ?> !important;
		border-radius: <?php echo get_option('qv-btn-br',2); ?> !important;
	    position: absolute !important;
	    top: 30% !important;
	    right: 0 !important;
	    margin-right: 50px !important;
	    width: 75% !important;
	    height: auto !important;
	    text-align: center !important;
	    z-index: 555 !important;
	    opacity: 0 !important;
	    transition: all .6s !important;
	    -webkit-transition: all .6s !important;
	    -moz-transition: all .6s !important;
	    -o-transition: all .6s !important;
	}
	.woocommerce .product_quick_view_button:hover {
		background: <?php echo $btn_bg_color_hov; ?> !important; 
		color:<?php echo $btn_color_hov; ?> !important;
	}
	.woocommerce li.product:hover .product_quick_view_button {
		opacity: 1 !important; 
	    margin-right: 0px !important;
	}
		
		@media  (max-width: 667px) and (min-width: 480px) {
			.woocommerce .product_quick_view_button {
				position: relative;
				opacity: 1;
	            margin-right: 0;
				padding: <?php echo get_option('qv-btn-txt-padding',6); ?>;
			}
		}
		@media (max-width: 480px) {
			.woocommerce .product_quick_view_button{
				display: none;
			}
		}



	<?php }elseif (get_option('qv-btn-pos')=='fixed') { ?>
		.woocommerce .product_quick_view_button{
		color: <?php echo $btn_color; ?> !important;
	    background-color: <?php echo $btn_bg_color; ?> !important;
		padding: <?php echo get_option('qv-btn-txt-padding',2); ?> !important;
		font-size: <?php echo get_option('qv-btn-txt-size',16); ?> !important;
		border-radius: <?php echo get_option('qv-btn-br',2); ?> !important;
	    text-align: center;
	    z-index: 555;
	    transition: all .6s !important;
	    -webkit-transition: all .6s !important;
	    -moz-transition: all .6s !important;
	    -o-transition: all .6s !important;
	}
	.woocommerce .product_quick_view_button:hover {
		background: <?php echo $btn_bg_color_hov; ?> !important; 
		color:<?php echo $btn_color_hov; ?> !important;
	}
	@media (max-width: 480px) {
		.woocommerce .product_quick_view_button{
			display: none !important;
		}
	}
/*	i.ws-qvb.loading{
	    position: absolute;
	    background-color: teal;
	    height: 50px;
	    width: 50px;
	    top: 40%;
	    left: 40%;
	    border-radius: 100%;
	}*/
	<?php } ?>
		i.ws-qvb.loading{
			background-color: <?php echo $btn_bg_color ?> !important;
			color: <?php echo $btn_color_hov ?> !important;
		}
	</style>
	<?php 
	} 
}

if ( ! function_exists( 'wrapshop_ajaxurl' )) {
	/**
	 * Wrap Shop Ajax url for Javascript
	 * Hooked into the `header`
	 *
	 * @since 1.0
	 * @return style
	 */
	function wrapshop_ajaxurl() {
	?>
		<script type="text/javascript">
			var wrapshop_ajaxurl = '<?php echo admin_url('admin-ajax.php', 'relative'); ?>';
		</script>
	<?php
	} 
}

if ( ! function_exists( 'wrapshop_quickview' )) {
	/**
	 * Display a Quick View Button in every Products
	 * Hooked into the `shop` products item
	 *
	 * @since 1.0
	 * @return style, html with data
	 */
	function wrapshop_quickview() {
		?>
	<div class="cd-quick-view woocommerce">
	</div> <!-- cd-quick-view -->
		<?php
	}
}

