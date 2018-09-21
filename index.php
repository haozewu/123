<?php
/*
Plugin Name: Ciabeta-Panel
Plugin URI: https://www.ciabeta.com/index.php/2018/09/08/380/
Description: 综合化一体式Wordpress网站管理工具
Version: 1.2
Author: Ciabeta
Author URI: https://www.ciabeta.com
*/

/**
 * 加入加锚功能
 */
function ciabeta_anchor($content){
	$settings = get_option('ciabeta-options');
	if($settings['num_on'] == 'on'){
		require_once('class.addanchor.php');
		/**
		* 犯了个小错误，重复加载了。
		*/
		// include('class.addanchor.php');
		$anchors = new Addanchor;
		return $anchors->add_index($content);
	}else{
		/**
		 * 如果不加这个就所有文章内容都不显示
		 */
		 return $content;
	}
}
add_filter( 'the_content', 'ciabeta_anchor');
/**
  *代码高亮应该加一个古藤保代码处理，如果没法处理就改古藤保返回的参，跟加锚一样
  */
function ciabeta_prism() {
	$settings = get_option('ciabeta-options');
	if($settings['prism_on'] == 'on'){
		require_once('class.prism.php');
		/**
		* 初始化该对象时候，自动加载css和js
		*/
		$withprism = new Prism;
	}
}
add_action( 'wp_head', 'ciabeta_prism' );
/**
 * 加一个返回顶部吧
 */
function ciabeta_backtop(){
	$settings = get_option('ciabeta-options');
	if($settings['backtop_on'] == 'on'){
		require_once('class.addbacktop.php');
		$backtop = new AddBacktop;
		// $backtop->($content);
	}
}
add_action( 'wp_head', 'ciabeta_backtop' );
/**
 * 加一个分享到QQ空间
 */
function ciabeta_share_qzone(){
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
add_action( 'wp_head', 'ciabeta_share_qzone' );
/**
 * 后台左上方的W图标看着好low，去掉它
 * 感谢使用wordpress创作也好low，去掉
 */
 function ciabeta_adminbar_remove() {
	global $wp_admin_bar;
	/* Remove their stuff */
	$wp_admin_bar->remove_menu('wp-logo');
}
function ciabeta_clear_footer_text() {
	return ''; 
}
function ciabeta_clear_footer() {
	return ''; 
}
add_filter( 'admin_footer_text', 'ciabeta_clear_footer_text', 10 ); 
add_filter( 'update_footer', 'ciabeta_clear_footer', 50 ); 
add_action('wp_before_admin_bar_render', 'ciabeta_adminbar_remove', 0);
/**
 * 后台太危险想要隐藏
 * 加个函数吧
 */
 function ciabeta_login_protection(){
	$settings = get_option('ciabeta-options');
	if($settings['protectlogin_on'] == 'on'){
	 if($_GET[$settings['loginprotect_name']] != $settings['loginprotect_value'])
		header('Location:'.get_bloginfo(url));
	}
}
add_action('login_enqueue_scripts','ciabeta_login_protection'); 
/**
 * 终于到了实现原创功能的时候了，下面的函数是发post的时候的回调函数，输出一个发post的时候的框的内容
 */
function ciabeta_main_save_iforign($post_id){
	require_once('class.orign.php');
	$orign = new Orign;
	return $orign->save_iforign($post_id);
}
function ciabeta_main_orign_out($content){
	if(is_single()){
		require_once('class.orign.php');
		$orign = new Orign;
		$content = $orign->orign_out($content);
	}
		return $content;
}
function ifpost_orign($post) {
	// 创建临时隐藏表单，为了安全
	wp_nonce_field( 'ifpost_orign_meta_box', 'ifpost_orign_nonce' );
	// 获取之前存储的值
	$if_orign_ok = get_post_meta($post->ID, 'if_post_orign', true);
	if($if_orign_ok == 'yes')
		$checked_ok = ' checked="checked"';
	//这里不要瞎用同一个参数！！
	echo '<span style="padding-top:5px;display:block;"><input type="checkbox" value="yes" name="if_post_orign"'.$checked_ok.' />申明为转载</span>';
}
/**
* 这个是控制post的那个框的实现，post和high有机会查查是什么用
*/
function ciabeta_iforign_meta_box() {
	if ( function_exists('add_meta_box') ) {
		/**判断是否有add_meta_box函数，这个不是系统函数么，有什么意义么？
		 * 我知道这个的函数了，是等待有post被编辑的时候实现。
		 * 第一个参数是box的id号
		 */
	add_meta_box( 'the-only-id', '原创申明', 'ifpost_orign', 'post', 'side', 'high' );
}
}
add_action('save_post', 'ciabeta_main_save_iforign');
add_action('admin_menu', 'ciabeta_iforign_meta_box');
add_filter( 'the_content', 'ciabeta_main_orign_out');
/**
 * 加一个后台菜单玩玩
 * 当点击menu page时，执行本指令
 */
function ciabeta_get_options(){
	require_once('class.optionpanel.php');
	$ciabeta_panel = new OptionPanel;
	$options = $ciabeta_panel->save_ciabeta_options();
	include( 'structure/options.php' );
}
function ciabeta_options(){
	add_menu_page( 'Ciabeta-Panel','Ciabeta-Panel', 'manage_options', 'Ciabeta-Panel',  'ciabeta_get_options', plugins_url( 'img/ciabeta.png', __FILE__ ));
}
add_action('admin_menu',  'ciabeta_options'  );

?>