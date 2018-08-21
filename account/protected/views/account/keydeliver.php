<?php
$this->pageTitle=Yii::app()->name . ' - 取得激活码';
$this->breadcrumbs=array(
	'取得激活码',
);
?>

<?php if($key) { ?>
&nbsp;
<h1>取得激活码</h1>
<br/>
<h3>恭喜！你已经成功取得了如下激活码，请复制保存激活码</h3>
<!--<h3>恭喜！你已经成功取得了如下激活码，请复制激活码保存或者直接点击链接激活游戏：</h3> -->
<!--<h4 style="color:red;font-weight:bold;"><?php echo $key;?></h4>-->
<h4>
	<input type="text" style="color:red;font-weight:bold;font-size:18px" value=<?php echo $key;?> />
	<input type="button" value="复制" id="copy-button"   />
</h4>
<!--<h3>恭喜！您已经成功注册账号，请直接点击链接激活游戏</h3>-->
<?php echo CHtml::link("激活游戏", '#', array(
	'submit'=>array('site/activate'),'params'=>array()
)); ?>
<!--
<?php echo CHtml::link("激活游戏", '#', array(
	'submit'=>array('site/activate'),
	'params'=>array('ActivateForm[key]'=>$key)
)); ?>
-->
<?php } else { ?>
<h3 style="font-weight:bold"><?php echo $res_code;?></h3>
<?php } ?>

<!--<script type="text/javascript" src="/js/jquery.min.js"></script>-->
<script type="text/javascript" src="/js/jquery.zclip.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$('#copy-button').zclip({
		path:'/js/ZeroClipboard.swf',
		copy:function(){return '<?php echo $key; ?>';},
		afterCopy:function(){
			alert("激活码已复制到剪贴板，你可以在需要的窗口中按Ctrl+V粘贴使用。");
		}
	 });
});
</script>
