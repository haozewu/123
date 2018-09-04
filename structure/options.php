
<?php
    /**
     * 包含所需的配置
     */
    echo '<link rel="stylesheet" href='.plugins_url( '../css/control.css', __FILE__ ).' />'; 
?>
<div>
    <h2 class="header">Ciabeta-Panel</h2>
    <form method="post" action="">
        <div class="option-left">
            <div class="diff-func">
                <h3 class="child-header">
                    <span class="header-text">代码高亮</span>
                </h3>
                <div class="panel-inside">
                <p class="func-notice">注意：详细的使用方法参考<a target="_blank" href="https://prismjs.com">Prism官网</a>。</p>
                    <input name='prism_on' type="checkbox"  <?php if($options['prism_on'] == 'on') echo 'checked=\"checked\"'; ?> />
                    <span>开启代码高亮功能</span>
                </div>
            </div>
            <div class="diff-func">
                <h3 class="child-header">
                        <span class="header-text">自动编号</span>
                </h3>
                <div class="panel-inside">
                    <input name='num_on' type="checkbox" <?php if($options['num_on'] == 'on') echo 'checked=\"checked\"'; ?> />
                    <span>开启自动编号功能</span>
                </div>
            </div>
            <div class="diff-func">
                <h3 class="child-header">
                    <span class="header-text">返回顶部</span>
                </h3>
                <div class="panel-inside">
                    <input name='backtop_on' type="checkbox" <?php if($options['backtop_on'] == 'on') echo 'checked=\"checked\"'; ?> />
                    <span>开启返回顶部功能</span>
                </div>
            </div>
            <div class="diff-func">
                <h3 class="child-header">
                    <span class="header-text">原创声明</span>
                </h3>
                <div class="panel-inside">
                    <input name='copyright_on' type="checkbox"  <?php if($options['copyright_on'] == 'on') echo 'checked=\"checked\"'; ?> />
                    <span>开启原创保护功能</span>
                </div>
                <div class="panel-inside">
                    <span>原创声明：</span>
                    <input type="input" name="orign" value=<?php echo $options['orign']; ?> />
                </div>
                <div class="panel-inside">
                    <span>转载声明：</span>
                    <input type="input" name="not_orign"  value=<?php echo $options['not_orign']; ?> />
                </div>
            </div>
            <div class="options_submit">
                <?php submit_button(); ?>
            </div>
        </div>
        <div class="option-right">
            <div class="diff-func">
                <h3 class="child-header">
                    <span class="header-text">分享到空间</span>
                </h3>
                <div class="panel-inside">
                    <p class="func-notice">这种功能会把你的post中的摘要作为内容发送到空间，开启前请检查你所有文章的摘要。</p>
                    <input name='sharequzone_on' type="checkbox"  <?php if($options['sharequzone_on'] == 'on') echo 'checked=\"checked\"'; ?> />
                    <span>开启功能</span>
                </div>
            </div>
            <div class="diff-func">
                <h3 class="child-header">
                    <span class="header-text">保护登录地址</span>
                </h3>
                <div class="panel-inside">
                    <p class="func-notice">你的登录地址已经变成：<br/><?php echo get_bloginfo(url).'/wp-login.php?'.$options['loginprotect_name'].'='.$options['loginprotect_value']; ?><br/>请妥善保存！</p>
                    <input name='protectlogin_on' type="checkbox"  <?php if($options['protectlogin_on'] == 'on') echo 'checked=\"checked\"'; ?> />
                    <span>开启功能</span>
                    <div class="panel-inside">
                    <span>校验参数名：</span>
                    <input type="input" name="loginprotect_name" value=<?php echo $options['loginprotect_name']; ?> />
                </div>
                <div class="panel-inside">
                    <span>校验参数值：</span>
                    <input type="input" name="loginprotect_value"  value=<?php echo $options['loginprotect_value']; ?> />
                </div>
                </div>
            </div>
        </div>
        
    </form>
</div>