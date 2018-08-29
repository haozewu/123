<?php
/*
Plugin Name: StructureBuilt
Plugin URI: https://example.com
Description: 用于官方主题显示文章层次结构
Version: 1.0
Author: 夏目秀明
Author URI: https://www.ciabeta.com
*/


/**
 * 加入加锚功能
 */
function anchor_add($content){
	require_once('class.addanchor.php');
	/**
	 * 犯了个小错误，重复加载了。
	 */
	// include('class.addanchor.php');
	$anchors = new Addanchor;
	return $anchors->add_index($content);
}
add_filter( 'the_content', 'anchor_add');
/**
 * 代码高亮功能
 */
function prism() {
	require_once('class.prism.php');
	/**
	 * 初始化该对象时候，自动加载css和js
	 */
	$withprism = new Prism;
}
add_action( 'wp_head', 'prism' );


/**
 * 加一个后台菜单玩玩
 * 当点击menu page时，执行本指令
 */
function get_options(){
	// $options = save_options();
	
	
	include( 'structure/options.php' );
}
function ciabeta_options(){
	
	add_menu_page( '123','结构设定', 'manage_options', 'structurebuilt',  'get_options', plugins_url( 'img/ciabeta.png', __FILE__ ));
}
add_action('admin_menu',  'ciabeta_options'  );


?>
