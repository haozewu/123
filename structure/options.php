
<?php
    /**
     * 包含所需的配置
     */
    echo '<link rel="stylesheet" href='.plugins_url( '../css/control.css', __FILE__ ).' />'; 
?>
<div>
    <h2 class="header">配置中心</h2>
    <form method="post" action="">
        <div class="option-left">
            <div class="prism-config">
                <h3 class="child-header">
                    <span class="header-text">Prism配置</span>
                </h3>
                <p>这里可以进行Prism代码高亮配置</p>
                <input name='prism_on' type="checkbox"  <?php if($options['prism_on'] == 'on') echo 'checked=\"checked\"'; ?> /><span>开启代码高亮功能</span>
            </div>
            <div class="prism-config">
            <h3 class="child-header">
                    <span class="header-text">自动编号配置</span>
            </h3>
                <p>这里可以进行自动编号配置</p>
                <input name='num_on' type="checkbox" <?php if($options['num_on'] == 'on') echo 'checked=\"checked\"'; ?> /><span>开启自动编号功能</span>
            </div>
            <div class="prism-config">
            <h3 class="child-header">
                    <span class="header-text">返回顶部配置</span>
            </h3>
                <p>这里可以进行返回顶部配置</p>
                <input name='backtop_on' type="checkbox" <?php if($options['backtop_on'] == 'on') echo 'checked=\"checked\"'; ?> /><span>开启返回顶部功能</span>
            </div>
            <div class="prism-config">
                <h3>原创申明配置</h3>
                <p>这里可以进行原创申明配置</p>
                <input name='copyright_on' type="checkbox"  <?php if($options['copyright_on'] == 'on') echo 'checked=\"checked\"'; ?> /><span>开启原创保护功能暂时不管用</span>
                <br/>
                <span>原创声明：</span><input type="input" name="orign" value=<?php echo $options['orign']; ?> />
                <br/>
                <span>非原创声明：</span><input type="input" name="not_orign"  value=<?php echo $options['not_orign']; ?> />
            </div>
        </div>
        <div>
            <?php submit_button(); ?>
        </div>
    </form>
</div>