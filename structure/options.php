
<?php
    /**
     * 包含所需的配置
     */
    echo '<link rel="stylesheet" href='.plugins_url( '../css/control.css', __FILE__ ).' />'; 
?>
<div>
    <h2 class="header">配置中心</h2>
    <div class="option-left">
        <div class="prism-config">
            <h3>Prism配置</h3>
            <p>这里可以进行Prism代码高亮配置</p>
            <input type="checkbox" /><span>开启代码高亮功能</span>
        </div>
        <div class="prism-config">
            <h3>自动编号配置</h3>
            <p>这里可以进行自动编号配置</p>
            <input type="checkbox" /><span>开启自动编号功能</span>
        </div>
    </div>


	<!-- <div id="copyright-switch">

		<form action="" method="post">
			<p>
                <label for="tmb">原创文章版权声明：</label>
                <br/>
				<textarea cols="60" rows="5" name="original-copyright">
                    <?php //echo $options['original-copyright'] ?>
                </textarea>
            </p>
			<p>
                <label for="tmb">非原创文章版权声明：</label>
                <br/>
				<textarea cols="60" rows="3" name="normal-copyright">
                    <?php //echo $options['normal-copyright'] ?>
                </textarea>
            </p>
            <div id="apTextFormat0Hint" class="nxs_FRMTHint" style="font-size: 11px; margin: 2px; margin-top: 0px; padding:7px; border: 1px solid #C0C0C0; width: 79%; background: #fff; ">
                <span class="nxs_hili">%TITLE%</span> - 插入POST的标题
                <br/>
                <span class="nxs_hili">%URL%</span> - 插入POST的URI
                <br/>
                <span class="nxs_hili">%CATS%</span> - 插入POST的范围
            </div>
            <?php //submit_button(); ?>
        </form>	
    </div> -->
    
	<!-- <div style="clear:both;"></div> -->
	<?php //form_bottom(); ?>
</div>