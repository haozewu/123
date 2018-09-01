<?php
    /**
     *注意这个功能必须要写后台的摘要，否则分享到空间会出问题
     */
    /**
     * 包含所需的配置
     */
    echo '<link rel="stylesheet" href='.plugins_url( '../css/shareqzone.css', __FILE__ ).' />'; 
?>
<script>
    function share2quzone(){
        ;
    };
</script>
<div class='share' onclick="share2quzone()">
        <!-- 由于每个图标有共有属性，又有各自特征，所以采用两个类 -->
        <!-- a[href="javascript:;"].backtop-item.backtop-item-weixin*4 -->
        <?php
        //注意下面这个url这一段本地localhost不成功，必须有.com。cn什么的后缀
        //获取文章的第一张图片地址
        function catch_first_image_2share(){
            global $post, $posts;
            $first_img = '';
            ob_start();
            ob_end_clean();
            $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches); 
        
            $first_img = '';
            if(empty($matches[1])) $first_img = "/default.jpg";
            else $first_img = $matches [1][0];
            return $first_img;//$matches[1];
        }
        ?>
        <a target="_blank" href=<?php echo "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?".
        "url=".get_permalink()."&title=".UrlEncode(get_the_title()."|".get_bloginfo('name'))."&summary=".UrlEncode(get_the_excerpt())."&desc="."我看过这篇文章，你可能会觉得它有趣。"."&pics=".catch_first_image_2share(); ?> class="share-item share-qzone"></a>
</div>