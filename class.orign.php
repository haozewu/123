<?php
class Orign{
    /**这段代码实现在保存post的时候执行，连同本参数一并保存 */
    function save_iforign( $post_id ) {
        // 安全检查
        // 检查是否发送了一次性隐藏表单内容（判断是否为第三者模拟提交）
        if ( ! isset( $_POST['ifpost_orign_nonce'] ) ) {
            return;
        }
        // 判断隐藏表单的值与之前是否相同
        if ( ! wp_verify_nonce( $_POST['ifpost_orign_nonce'], 'ifpost_orign_meta_box' ) ) {
            return;
        }
        // 判断该用户是否有权限
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        // 判断 Meta Box 是否为空，要是空的话说明不是原创，这个不能不保存
        // if ( ! isset( $_POST['if_post_orign'] ) ) {
        //     return;
        // }
        $if_post_orign = $_POST['if_post_orign'];
        update_post_meta( $post_id, 'if_post_orign', $if_post_orign );
    }
    //原创整合部分
    function orign_out($content){
        $settings = get_option('ciabeta-options');
        //没有声明global，就显示有问题
        if($settings['copyright_on'] == 'on'){
        global $post;
        $orign_query = get_post_meta($post->ID, 'if_post_orign', true);
        if($orign_query == 'yes')
            $content .= $settings['not_orign'];
            else {
                $content .= $settings['orign'];
            }
        }
        return $content;
    }

}