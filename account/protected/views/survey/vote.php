<?php
/* @var $this SurveyController */
// echo $this->id . '/' . $this->action->id;

$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->request->baseUrl.'/css/jqui/jquery-ui-1.9.2.custom.min.css');

?>
<?php if (strlen($info) > 0) { ?>
<script type="text/javascript">
$(document).ready(function() {
	$("<div title=\"投票结果\"><?php echo $info; ?></div>").dialog({
        resizable: false,
        modal: true,
        buttons: {
            "OK": function()
            {
                $( this ).dialog( "close" );
            }
        }
    });
});
</script>
<?php } ?>
<div id="content" style="position:relative;left:31px;width:966px;background-color:rgb(26,100,137);padding-bottom:25px;">
	<div class="zj">
		<div id="panda"></div>
		<div id="tiger"></div>
		<div id="deer"></div>
		<div id="horse"></div>

		<div class="button"	style="left:140px;top:454px;"><a href="/account/index.php/survey/vote?subject=1&option=1">熊猫</a></div>
		<div class="button"	style="left:602px;top:454px;"><a href="/account/index.php/survey/vote?subject=1&option=2">虎</a></div>
		<div class="button"	style="left:135px;top:900px;"><a href="/account/index.php/survey/vote?subject=1&option=3">鹿</a></div>
		<div class="button"	style="left:601px;top:900px;"><a href="/account/index.php/survey/vote?subject=1&option=4">马</a></div>
	</div>
	<div class="ztcontent" style="margin-left:30px;margin-right:20px;">
		</p>
		<h3>活动时间：</h3>
			<p class="li">即日起---2013年11月20日</p>
         </p>
			<h3>活动对象：</h3>
			<p class="li">所有玩家</p>
			</p>
			<h3>活动内容:</h3>
			<p class="li">登录官方网站，为拍拍投新出的4种坐骑投上一票，票活动结束时统计出投票最多的坐骑，投该坐骑的全部玩家都可以获得大奖一份，所有参与活动的玩家都可以获得参与奖一份。</p>
			</p>
			<h3>领奖方法:</h3>
			<p class="li">2013年11月20日~11月25日，系统会把领奖CDKEY发送到领奖中心，<sp class="important">玩家可登录官网【用户中心】---【奖励中心】</sp>，领取奖励CDKEY。</p>
			<p class="li">参与投票的玩家可以使用此CDKEY，在游戏内输入CDKey领取奖励。</p>
			</p>
		<h3>注意：</h3>
			<ol>
				<li>账号和CDKey绑定，即该账号领取到的CDKey只可作用于该账号下的角色。</li>
				<li>每个CDKey使用一次后失效。</li>
			</ol>
			</p>
			<h3>奖励内容:</h3>
			<p class="li"><sp class="important">最受欢迎坐骑投票奖：绝世神功残页*1,坐骑令*2, 毛绒球*1</sp></p>
			<p class="li"><sp class="important">坐骑投票参与奖：洗髓丹*10, 优质牧草*1</sp></p>
	</div>
</div>

