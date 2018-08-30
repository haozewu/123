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
  *代码高亮应该加一个古藤保代码处理，如果没法处理就改古藤保
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
 * 加一个后台菜单玩玩
 * 当点击menu page时，执行本指令
 */
 function save_ciabeta_options(){
	if( $_POST['submit'] ){
		$save_data=array(
			'prism_on' => $_POST['prism_on'],
			'num_on' => $_POST['num_on'],
			'backtop_on' => $_POST['backtop_on'],
			'copyright_on' => $_POST['copyright_on'],
			'orign' => $_POST['orign'],
			'not_orign' => $_POST['not_orign'],
		);
		/**
		 * 调试查看是否得到参数
		 */
		 include('class.debug.php');
		 $mydebug = new MyDebug;
		 $mydebug->console_log($save_data);
		update_option( 'ciabeta-options', $save_data );
	}
	return get_option( 'ciabeta-options' );
}

function get_options(){
	$options = save_ciabeta_options();
	include( 'structure/options.php' );
}
function ciabeta_options(){
	
	add_menu_page( '123','结构设定', 'manage_options', 'structurebuilt',  'get_options', plugins_url( 'img/ciabeta.png', __FILE__ ));
}
add_action('admin_menu',  'ciabeta_options'  );


?>
