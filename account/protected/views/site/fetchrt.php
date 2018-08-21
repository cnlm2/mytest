<?php
$this->pageTitle=Yii::app()->name . ' - 密码找回';
$this->breadcrumbs=array(
	'密码找回',
);
?>
<style type="text/css">
<!--
#account {
	font-weight:bold;
	color: red;
}
#email {
	font-weight:bold;
	color: red;
}
-->
</style>
&nbsp;
<!--<h1>密码找回</h1>-->
<h3><strong class="title-9">登录</strong></h3>
&nbsp;
<div class="form">
<h4>已将账号 <span id="account"><?php echo $account; ?></span> 的重置链接发送至邮箱 <span id="email"><?php echo $email; ?></span>。<br/>
请于24小时内通过重置链接重新设定您的密码！</h4>
<p>注：
<ol>
	<li>有些邮箱会误将重置邮件当成垃圾邮件，请到垃圾邮箱看看！</li>
	<li>近期QQ邮箱接收验证邮件不稳定，请参考<a href="/bbs/forum.php?mod=viewthread&tid=8463&extra=page%3D1">此文</a>解决</li>
</ol>
</p>
</div>

