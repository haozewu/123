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
	}else{
		/**
		 * 如果不加这个就所有文章内容都不显示
		 */
		 return $content;
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
 * 终于到了实现原创功能的时候了，下面的函数是发post的时候的回调函数，输出一个发post的时候的框的内容
 */
function main_save_iforign($post_id){
	require_once('class.orign.php');
	$orign = new Orign;
	return $orign->save_iforign($post_id);
}
function main_orign_out($content){
	require_once('class.orign.php');
	$orign = new Orign;
	$content = $orign->orign_out($content);
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
	echo '<span style="padding-top:5px;display:block;"><input type="checkbox" value="yes" name="if_post_orign"'.$checked_ok.' />申明为原创</span>';
}
    /**
     * 这个是控制post的那个框的实现，post和high有机会查查是什么用
     */
     function iforign_meta_box() {
        if ( function_exists('add_meta_box') ) {
            /**判断是否有add_meta_box函数，这个不是系统函数么，有什么意义么？
             * 我知道这个的函数了，是等待有post被编辑的时候实现。
             * 第一个参数是box的id号
             */
            add_meta_box( 'the-only-id', '原创申明', 'ifpost_orign', 'post', 'side', 'high' );
        }
    }
add_action('save_post', 'main_save_iforign');
add_action('admin_menu', 'iforign_meta_box');
add_filter( 'the_content', 'main_orign_out');
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
	add_menu_page( 'Ciabeta-Panel','Ciabeta-Panel', 'manage_options', 'Ciabeta-Panel',  'get_options', plugins_url( 'img/ciabeta.png', __FILE__ ));
}
add_action('admin_menu',  'ciabeta_options'  );

?>
