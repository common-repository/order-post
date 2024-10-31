<?php wp_enqueue_script("jquery");?>
<?php wp_enqueue_script( 'jquery-ui-sortable' );?>
<?php $plugindir = get_option('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));
add_action( 'wp_enqueue_scripts', 'wpo_scripts_mask_method' );
function wpo_scripts_mask_method() {
$plugin_url=plugins_url()."/wp_post_order";
    wp_enqueue_script(
		'mask-and-preloader',
		$plugin_url. '/js/mask-and-preloader.js',
		array( 'jquery' )
	);
}

$plugin_url=plugins_url()."/wp_post_order";
wp_register_style( 'wpvs-style', ''.$plugin_url.'/css/wp_post.css' );
wp_enqueue_style( "wpvs-style" );
?>
<?php
wp_enqueue_script(
                'drag_and_drop',
                plugins_url( '/js/drag_and_drop.js' , __FILE__ ),
                array('jquery-ui-core', 'jquery-ui-mouse', 'jquery-ui-sortable')
        );

?>




