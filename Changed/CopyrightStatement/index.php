<?php 
/*
Plugin Name: CopyrightStatement
Plugin URI: https://example.com
Description: 自定义文章的版权信息，原创文章和转载文章显示不同的版权信息，魔改版，原版不符合规定。
Version: 1.0
Author: 原作者屏蔽
Author URI: https://example.com
*/

	//menu page
	function menu_page(){
		add_menu_page( 'Copyright Switch','版权管理', 'manage_options', 'copyright-switch',  'options_form', plugins_url( 'favicon.png', __FILE__ ) );
	}
	
	/**
	 * 当点击menu page时，执行本指令
	 */
	function options_form(){
		$options = save_options();
		include( 'options-form.php' );
	}
	



/**
 * 在执行post发布或者更新文章时执行此命令
 * @param 文章id号
 */
function save_postdata( $post_id ) {
    global $post, $copyright_meta_boxes;

    foreach($copyright_meta_boxes as $meta_box) {
        if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) ))  {
            return $post_id;
        }

        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ))
                return $post_id;
        }
        else {
            if ( !current_user_can( 'edit_post', $post_id ))
                return $post_id;
        }

        $data = $_POST[$meta_box['name'].'_value'];

        if(get_post_meta($post_id, $meta_box['name'].'_value') == "")
            add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
        elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
            update_post_meta($post_id, $meta_box['name'].'_value', $data);
        elseif($data == "")
            delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
    }
}

//文章末尾加版权声明函数
function wp_copyright($content) {
	if (is_single ()) {
		global $post;
		$copyright_info="";
		$isOriginal = get_post_meta($post->ID, 'is_original_value', true);
		$copyright_options=get_option( 'copyright-switch-options' );
		
		/**
		 * 根据是否原创参数来确定追加文本
		 * @param yes, no
		 */
		if($isOriginal == "yes")
			$copyright_info=$copyright_options['original-copyright'];
		else
			$copyright_info=$copyright_options['normal-copyright'];
		/**
		 * 此处是做三种特殊字符的具体替代实现
		 */
		$copyright_info=str_ireplace("%TITLE%",get_the_title(),$copyright_info);
		$copyright_info=str_ireplace("%URL%",get_permalink(),$copyright_info);
		if(stristr($copyright_info,"%CATS%")) {
	  	$category = get_the_category(); 
	  	$this_category=$category[0];
	  	$cathtml='';
			if($this_category){
				$cathtml= '<a href="'.get_category_link($this_category->term_id ).'">'.$this_category->cat_name.'</a>';
				while($this_category->category_parent)
				{
					$this_category = get_category($this_category->category_parent); 
					$cathtml .= ' - <a href="'.get_category_link($this_category->term_id ).'">'.$this_category->cat_name.'</a>';
				}
			}
			$copyright_info=str_ireplace("%CATS%",$cathtml,$copyright_info);
		}
		
		/**
		 * 实现语句
		 */
		$content.=$copyright_info;
	}
	return $content;
} 

//filter and action hook
add_action('admin_menu',  'menu_page'  );		//menu page
add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
add_filter('the_content', 'wp_copyright',0); // 文章末尾增加版权

	/**
	 * 这里是执行另一页submit_button();的函数
	 */
	function save_options(){
		if( $_POST['submit'] ){
			$data=array(
				'original-copyright' => $_POST['original-copyright'],
				'normal-copyright' => $_POST['normal-copyright']
			);
			update_option( 'copyright-switch-options', $data );
		}
		return get_option( 'copyright-switch-options' );
	}

	/**
	 * 操作框末尾的插件介绍，不得不说这代码也是很可以了，函数里直接加 ?>， <?php
	 */
	function form_bottom(){
		?>
			<div id="form-bottom" style="width:650px;border:1px dotted #ddd;background-color:#f7f7f7;padding:10px;margin-top:20px;">
				<p>插件介绍：<a href="https://example.com" target="_blank">https://example.com</a></p>
				
			</div>
		<?php
			}



			
/**
 * 这里是在编辑文章页面添加一个框
 * 
 */
	$copyright_meta_boxes =
	array(
		"is_original" => array(
			"name" => "is_original",
			"std" => "",
			"title" => "申明为原创")
	);

	function copyright_switch_meta_boxes() {
		global $post, $copyright_meta_boxes;

		foreach($copyright_meta_boxes as $meta_box) {
			$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);

			if($meta_box_value == "")
				$meta_box_value = $meta_box['std'];

			echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
			?>
					<span style="padding-bottom:5px;display:inline-block;"><input type="checkbox" name="<?= $meta_box['name'] ?>_value" <?=checked( "yes", $meta_box_value,"checked")?>  value="yes" /><?=$meta_box['title']?></span>
				<?php 
		}
	}
	/**
	 * 原作者加的位置不合适，会影响文章的滑动
	 * 这里改成了侧边显示
	 * @param string side
	 */
	function create_meta_box() {
		global $theme_name;

		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'copyright-switch-meta-boxes', '原创申明', 'copyright_switch_meta_boxes', 'post', 'side', 'high' );
		}
	}