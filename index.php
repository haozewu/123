<?php
/*
Plugin Name: StructureBuilt
Plugin URI: http://#
Description: 用于官方主题显示文章层次结构
Version: 1.0
Author: 夏目秀明
Author URI: https://www.zetrix.cn
*/


// This just echoes the chosen line, we'll position it later
function hello_dolly($content) {
	if(is_single()) {
		// [^>]表示不是“>”的字符，*表示重复零次或更多次，这个意思是非“>”的字符可以有一个或多个，也可以没有。
		// 点代表的是任意字符。
		// * 代表的是取 0 至 无限长度问号代表的是非贪婪模式。三个链接在一起是取尽量少的任意字符。
		$rex = "/(<(h2|h3|h4)>)(.*?)(<\/(h2|h3|h4)>)/";
		//通配所有h2h23h4
		preg_match_all($rex, $content, $matches,PREG_SET_ORDER);
		foreach ($matches as $val) {
			if($val[2] == "h2"){
				//class="has-regular-font-size"
				$label = '<p class="has-regular-font-size">'.$val[3]."</p>";
			}
			if($val[2] == "h3"){
				//class="has-small-font-size"
				$label = '<p class="has-small-font-size">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$val[3]."</p>";
			}
			$headers .= $label;
		}
		//从第一个h2开始分割，也就是以后的正文第一个就要是h2标签，以0X1开始
		$moreandh2 = preg_split('<h2>', $content, 2);
		$content = $moreandh2[0]."h2>0X0 目录</h2>".$headers."<h2".$moreandh2[1];	
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