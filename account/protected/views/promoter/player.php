<?php
/* @var $this ChargeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'推广',
);

$this->initMenu();
?>
<!--
&nbsp;
<h1>订单</h1>
&nbsp;
-->

<h3><strong class="title-5">玩家信息</strong></h3>
&nbsp;

<form method="get">
	查询时间&nbsp;&nbsp;&nbsp;<input type="date" name="Account[StartTime]"  value = <?php if ($starttime) {echo $starttime;} else {echo date("Y-m-d");} ?> >
	&nbsp;至&nbsp;            <input type="date" name="Account[EndTime]"  value = <?php if ($endtime) {echo $endtime;} else {echo date("Y-m-d");} ?> >
	&nbsp;&nbsp;              <input type="submit" value="查  询" style="background:#bda388;width:60px;height:30px;border:none;cursor:pointer;color:#fff"/>
</form>

<?php
if ($models) {
	$url_excel = Yii::app()->createUrl("promoter/playerexcel", array('Account[StartTime]'=>$starttime,'Account[EndTime]'=>$endtime));
	echo("<a style='float:left;margin-left:450px;margin-top:-30px;width:60px;height:30px;cursor:pointer;background:#bda388;color:#fff;text-align:center;line-height:2.5;;text-decoration:none' href= $url_excel>下载excel</a>");
}
?>


&nbsp;
<table id='charges'>
	<tr>
		<th>账号</th>
		<th>角色Id</th>
		<th>角色名</th>
		<th>创建时间</th>
		<th>等级</th>
		<th>门派</th>
		<th>兑换元宝</th>
		<th>vip等级</th>
	</tr>
<?php
$line = 0;
if($models) {
	foreach ($models as $model) {
		$line = $line+1;
		$this->renderPartial("playerview", array(
			'data'=>$model,
			'parity'=> $line % 2 == 0 ? 'even' : 'odd',
		));
	}
}
?>
</table>
<div id="pagelink">
<?php 
if($pages) {
	$this->widget('CLinkPager', array(
		'pages'=> $pages,
		'cssFile'=>false,
	));
}
?>
</div>

