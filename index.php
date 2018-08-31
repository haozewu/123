<?php
/*
Plugin Name: Ciabeta-Panel
Plugin URI: https://example.com
Description: 综合化一体式Wordpress网站管理工具
Version: 1.2
Author: Ciabeta
Author URI: https://www.ciabeta.com
*/


/**
 * 加入加锚功能
 */
function anchor_add($content){
	$settings = get_option('ciabeta-options');
	if($settings['num_on'] == 'on'){
		require_once('class.addanchor.php');
	/**
	 * 犯了个小错误，重复加载了。
	 */
	// include('class.addanchor.php');
	$anchors = new Addanchor;
	return $anchors->add_index($content);
	}
}
add_filter( 'the_content', 'anchor_add');
/**
  *代码高亮应该加一个古藤保代码处理，如果没法处理就改古藤保返回的参，跟加锚一样
  */
function prism() {
	$settings = get_option('ciabeta-options');
	if($settings['prism_on'] == 'on'){
		require_once('class.prism.php');
		/**
		* 初始化该对象时候，自动加载css和js
		*/
		$withprism = new Prism;
	}
}
add_action( 'wp_head', 'prism' );
/**
 * 加一个返回顶部吧
 */
function backtop(){
	$settings = get_option('ciabeta-options');
	if($settings['backtop_on'] == 'on'){
		require_once('class.addbacktop.php');
		$backtop = new AddBacktop;
		// $backtop->($content);
	}
}
add_action( 'wp_head', 'backtop' );
/**
 * 加一个分享到QQ空间
 */
function share_qzone(){
	/**
	 * 是文章页再放开
	 */
	if(is_single() == true){
		$settings = get_option('ciabeta-options');
		if($settings['sharequzone_on'] == 'on'){
			require_once('class.shareqzone.php');
			$share_qzone = new ShareQzone;
		}
	}
}
add_action( 'wp_head', 'share_qzone' );
/**
 * 后台左上方的W图标看着好low，去掉它
 * 感谢使用wordpress创作也好low，去掉
 */
 function annointed_admin_bar_remove() {
	global $wp_admin_bar;
	/* Remove their stuff */
	$wp_admin_bar->remove_menu('wp-logo');
}
function my_admin_footer_text() {
	return ''; 
}
function my_update_footer() {
	return ''; 
}
add_filter( 'admin_footer_text', 'my_admin_footer_text', 10 ); 
add_filter( 'update_footer', 'my_update_footer', 50 ); 
add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);
/**
 * 后台太危险想要隐藏
 * 加个函数吧
 */
 function login_protection(){
	$settings = get_option('ciabeta-options');
	if($settings['protectlogin_on'] == 'on'){
	 if($_GET[$settings['loginprotect_name']] != $settings['loginprotect_value'])
		header('Location:'.get_bloginfo(url));
	}
}
add_action('login_enqueue_scripts','login_protection'); 

/**
 * 加一个后台菜单玩玩
 * 当点击menu page时，执行本指令
 */
function get_options(){
	require_once('class.optionpanel.php');
	$ciabeta_panel = new OptionPanel;
	$options = $ciabeta_panel->save_ciabeta_options();
	include( 'structure/options.php' );
}
function ciabeta_options(){
	
	add_menu_page( '123','Ciabeta-Panel', 'manage_options', 'Ciabeta-Panel',  'get_options', plugins_url( 'img/ciabeta.png', __FILE__ ));
}
add_action('admin_menu',  'ciabeta_options'  );

?>
