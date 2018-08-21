<?php
/* @var $this ChargeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'充值',
);

$this->initMenu();
?>
<!--
&nbsp;
<h1>订单</h1>
&nbsp;
-->
<h3><strong class="title-5">订单列表</strong></h3>
&nbsp;
<table id='charges'>
	<tr>
		<th>充值账号</th>
		<th>账单金额</th>
		<th>游戏点数</th>
		<th>创建时间</th>
		<th>充值类型</th>
		<th>账单状态</th>
		<th></th>
	</tr>
<?php
$line = 0;
foreach ($models as $model) {
	$line = $line+1;
	$this->renderPartial("_view", array(
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

