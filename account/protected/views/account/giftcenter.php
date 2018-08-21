<?php
$this->breadcrumbs=array(
	'奖励中心',
);

$this->initMenu();
?>
<h3><strong class="title-1">奖励中心</strong></h3>

<table id='giftcards'>
	<tr>
		<!--<th>账号</th>-->
		<th>礼品卡号</th>
		<th>活动</th>
	</tr>
<?php
$line = 0;
foreach ($models as $model) {
	$line = $line+1;
	$this->renderPartial("_giftcard", array(
		'data'=>$model,
		'parity'=> $line % 2 == 0 ? 'even' : 'odd',
	));
}
?>
</table>
<div id="pagelink">
<?php $this->widget('CLinkPager', array(
	'pages'=> $pages,
	'cssFile'=>false,
)) ?>
</div>

