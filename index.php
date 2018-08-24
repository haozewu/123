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
function add_anchor($single_text){
	$all_head2 = preg_split('<h2>', $single_text);
	$num = 0;
	foreach ($all_head2 as $each_one) {
		// if(($num+1) == sizeof($all_head2)){
		// 	//do nothing, just to avoid the error anchor print
		// 	$all_texth .= "h2".$each_one;
		// }else 
		if($num == 0){
			$all_text .= $each_one."h2";
		}else if(($num%2) == 0){
			if(($num+1) ==sizeof($all_head2)){
				$all_text .= $each_one;
			}else{
				$all_text .= $each_one."h2 id=\"header2-".$num."\"";
			}
		}else{
			$all_text .= $each_one."h2";
		}
		$num += 1;
	}
	$all_head3 = preg_split('<h3>', $all_text);
	$num = 0;
	foreach ($all_head3 as $each_one) {
		if(sizeof($all_head3) == 1){
			//do nothing, just to avoid the error anchor print
			$all_texth3 = $all_text;
		}else if(($num%2) == 0){
			if(($num+1) ==sizeof($all_head3)){
				$all_texth3 .= $each_one;
			}else{
				$all_texth3 .= $each_one."h3 id=\"header3-".$num."\"";
			}
		}else{
			$all_texth3 .= $each_one."h3";
		}
		$num += 1;
	}
	return $all_texth3;
}
function add_index($content) {
	if(is_single()) {
		// [^>]表示不是“>”的字符，*表示重复零次或更多次，这个意思是非“>”的字符可以有一个或多个，也可以没有。
		// 点代表的是任意字符。
		// * 代表的是取 0 至 无限长度问号代表的是非贪婪模式。三个链接在一起是取尽量少的任意字符。
		$rex = "/(<(h2|h3|h4)>)(.*?)(<\/(h2|h3|h4)>)/";
		//通配所有h2h23h4
		preg_match_all($rex, $content, $matches,PREG_SET_ORDER);
		//生成顺序表
		$h3_num = 0;
		$num = 1;
		foreach ($matches as $val) {
			if($val[2] == "h2"){
				//class="has-regular-font-size"
				$label = '<p class="has-regular-font-size"><a href=#header2-'.($num*2).'>'.$val[3]."</a></p>";
			}
			if($val[2] == "h3"){
				//class="has-small-font-size"
				$label = '<p class="has-small-font-size">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=#header3-'.($h3_num*2).'>'.$val[3]."</a></p>";
				$h3_num += 1;
			}
			$headers .= $label;
			$num += 1;
		}
		//从第一个h2开始分割，也就是以后的正文第一个就要是h2标签，以0X1开始
		$moreandh2 = preg_split('<h2>', $content, 2);
		$content = $moreandh2[0]."h2>0X0 目录</h2>".$headers."<h2".$moreandh2[1];
		$content = add_anchor($content);
	  }
	  return $content;
}
// Now we set that function up to execute when the admin_notices action is called
add_filter( 'the_content', 'add_index' );

// We need some CSS to position the paragraph
function prism_css() {
	echo '<link rel="stylesheet" href="https://web-share.bj.bcebos.com/css/prism.css" />
	<script src="https://web-share.bj.bcebos.com/js/prism.js" type="text/javascript"></script>
	';
}
add_action( 'wp_head', 'prism_css' );

?>
