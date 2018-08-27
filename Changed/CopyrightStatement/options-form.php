<style type="text/css">
#copyright-switch{ width:650px; margin:20px 0;border:1px solid #ddd; background-color:#f7f7f7; padding:10px; }
#copyright-switch span.des{ color:#999; margin-left:10px; }
#copyright-switch label{ width:500px; display:inline-block }
</style>

<div class="wrap">

	<div id="icon-options-general" class="icon32"><br></div>
	<h2>文章版权配置</h2>

	<div id="copyright-switch">
		<form action="" method="post">
			<p><label for="tmb">原创文章版权声明：</label><br/>
				<textarea cols="60" rows="5" name="original-copyright"><?php echo $options['original-copyright'] ?></textarea></p>
			
			<p><label for="tmb">非原创文章版权声明：</label><br/>
				<textarea cols="60" rows="3" name="normal-copyright"><?php echo $options['normal-copyright'] ?></textarea></p>	
      <div id="apTextFormat0Hint" class="nxs_FRMTHint" style="font-size: 11px; margin: 2px; margin-top: 0px; padding:7px; border: 1px solid #C0C0C0; width: 79%; background: #fff; ">
<span class="nxs_hili">%TITLE%</span> - 插入POST的标题
<br/><span class="nxs_hili">%URL%</span> - 插入POST的URI
<br/><span class="nxs_hili">%CATS%</span> - 插入POST的范围
      </div>


		<?php submit_button(); ?>
		</form>	
	</div>
	
	<div style="clear:both;"></div>
	
	<?php form_bottom(); ?>

</div>