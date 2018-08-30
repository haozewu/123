<?php
    /**
     * 包含所需的配置
     */
    echo '<link rel="stylesheet" href='.plugins_url( '../css/backtop.css', __FILE__ ).' />'; 
?>
<script>
    function smoothscroll(){
        var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
        if (currentScroll > 0) {
            window.requestAnimationFrame(smoothscroll);
            window.scrollTo (0,currentScroll - (currentScroll/5));
        }
    };
</script>
<div class='backtop' onclick="smoothscroll()">
        <!-- 由于每个图标有共有属性，又有各自特征，所以采用两个类 -->
        <!-- a[href="javascript:;"].backtop-item.backtop-item-weixin*4 -->
        <a href="javascript:;" class="backtop-item backtop-item-top"></a>
</div>