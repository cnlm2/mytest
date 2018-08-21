
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
</head>
<body>
<script type="text/javascript">
	<!--
	jQuery(document).ready(function() {
		window.top.location.href = $('.target').attr("href");
	});
	// -->
</script>
<?php echo CHtml::link('请稍候...', array($url), array('class'=>'target'));?>
</body>
</html>



