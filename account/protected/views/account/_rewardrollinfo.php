<?php if ($info === "reward") { ?>
<div class="info"><p></p></div>
<?php } elseif ($info === "no_verify_email") { ?>
<div class="info"><p>请验证您的邮箱，确保奖品准确及时发放。点击<?php echo CHtml::link("账号安全", "update/1");?>进行验证后，继续进入抽奖程序！</p></div>
<?php } elseif ($info === "not_yet") { ?>
<div class="info"><p>现在不是活动时间哟~</p></div>
<?php } else { ?>
<div class="name"><?php echo $model->account; ?></div>
<div class="email"><?php echo $model->email; ?></div>
<?php	if ($info === "IP") { ?>
<div class="image"><img src="/images/huodong/gqreward/ipad.png" alt="IPAD"></img></div>
<div class="comment">
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} elseif ($info === "MU") { ?>
<div class="image"><img src="/images/huodong/gqreward/mouse.png" alt="mouse"></img></div>
<div class="comment">
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} elseif ($info === "QB") { ?>
<div class="image"><img src="/images/huodong/gqreward/qb.png" alt="qb"></img></div>
<div class="comment">
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} elseif ($info === "L1") { ?>
<div class="image"><img src="/images/huodong/gqreward/l1.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} elseif ($info === "L2") { ?>
<div class="image"><img src="/images/huodong/gqreward/l2.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} elseif ($info === "L3") { ?>
<div class="image"><img src="/images/huodong/gqreward/l3.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} elseif ($info === "L4") { ?>
<div class="image"><img src="/images/huodong/gqreward/l4.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>
<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} elseif ($info === "L5") { ?>
<div class="image"><img src="/images/huodong/gqreward/l5.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>

<?php	} elseif ($info === "30QB") { ?>
<div class="image"><img src="/images/huodong/gqreward/qb.png"></img></div>
<div class="key">KEY: <?php echo $key; ?></div>


<div class="comment">
	<p>* 复制Key登录游戏，在媒体礼包界面输入Key领取奖励。</p>
	<p>* 奖励信息已发至您的邮箱，请注意查收！</p>
</div>
<?php	} ?>
<?php } ?>

