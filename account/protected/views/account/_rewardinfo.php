<?php if ($info === "no_sign_7_days") { ?>
<div class="info"><p>很抱歉！亲！您未完成5天连续签到，暂时不能参与抽奖！谢谢参与！</p></div>
<?php } elseif ($info === "no_verify_email") { ?>
<div class="info"><p>请验证您的邮箱，确保奖品准确及时发放。点击<?php echo CHtml::link("账号安全", "update/1");?>进行验证后，继续进入抽奖程序！</p></div>
<?php } elseif ($info === "not_open") { ?>
<div class="info"><p>抽奖活动将于8月12日12时至8月26日24时之间开启，千万要记得来参加哟~</p></div>
<?php } elseif ($info === "error_url") { ?>
<div class="info"><p>请从游戏内点击活动链接~</p></div>
<?php } elseif ($info === "not_finish") { ?>
<div class="info"><p>请将你手中的三票都投出去哦！<a href="/zhuanti/201408/?e=01">点击投票</a></p></div>
<?php } else { ?>
<div class="name"><?php echo $model->account; ?></div>
<div class="email"><?php echo $model->email; ?></div>
<?php	if ($info === "IP") { ?>
<div class="image"><img src="/images/huodong/gqreward/ipad.png" alt="IPAD"></img></div>
<div class="comment">
</div>
<?php	} elseif ($info === "MU") { ?>
<div class="image"><img src="/images/huodong/gqreward/mouse.png" alt="mouse"></img></div>
<div class="comment">
</div>
<?php	} elseif ($info === "Q3") { ?>
<div class="image"><img src="/images/huodong/gqreward/30.png" alt="qb"></img></div>
<div class="comment">
</div>
<?php	} elseif ($info === "Q1") { ?>
<div class="image"><img src="/images/huodong/gqreward/10.png" alt="qb"></img></div>
<div class="comment">
</div>
<?php	} elseif ($info === "L1") { ?>
<div class="image"><img src="/images/huodong/gqreward/l1.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
</div>
<?php	} elseif ($info === "L2") { ?>
<div class="image"><img src="/images/huodong/gqreward/l2.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
</div>
<?php	} elseif ($info === "L3") { ?>
<div class="image"><img src="/images/huodong/gqreward/mc.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
</div>
<?php	} elseif ($info === "L4") { ?>
<div class="image"><img src="/images/huodong/gqreward/l3.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
</div>
<?php	} elseif ($info === "L5") { ?>
<div class="image"><img src="/images/huodong/gqreward/l5.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} ?>
<?php } ?>

