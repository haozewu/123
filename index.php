<?php
/*
Plugin Name: StructureBuilt
Plugin URI: http://#
Description: 用于官方主题显示文章层次结构
Version: 1.0
Author: 夏目秀明
Author URI: https://www.zetrix.cn
*/


function hello_dolly_get_lyric() {
	/** These are the lyrics to Hello Dolly */
	$lyrics = "this is a small test!
	this is also a small test";

	// Here we split it into lines
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later
function hello_dolly($content) {
	$chosen = hello_dolly_get_lyric();
	
	if(is_single()) {     
		$content .= "<p id='dolly'>$chosen</p>";
	  }
	  return $content;
}

// Now we set that function up to execute when the admin_notices action is called
add_filter( 'the_content', 'hello_dolly' );

// We need some CSS to position the paragraph
function dolly_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#dolly {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}

add_action( 'admin_head', 'dolly_css' );

?>