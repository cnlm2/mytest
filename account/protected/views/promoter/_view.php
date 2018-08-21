<?php
/* @var $this ChargeController */
/* @var $data Charge */
?>
<?php
/*
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('no')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->no), array('view', 'id'=>$data->no)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account')); ?>:</b>
	<?php echo CHtml::encode($data->account->account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fee')); ?>:</b>
	<?php echo CHtml::encode($data->fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time')); ?>:</b>
	<?php echo CHtml::encode($data->time); ?>
	<br />

</div>
*/
?>

<tr class='charge <?php echo $parity?>'>
	<td class='charge'>
		<?php echo CHtml::encode($data->account->account); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->fee); ?> 元
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->point); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->time); ?>
	</td>
	<!--
	<td class='charge'>
		<?php echo CHtml::encode($data->getChargeTypeName()); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->getStatusName()); ?>
	</td>
	-->
	<!--
	<td class='charge'>
		<?php
		//if($data->status==Charge::CREATED) {
		//	if ($data->charge_type == "yd" ||
		//		$data->charge_type == "dx" ||
		//		$data->charge_type == "lt") {
		//		echo CHtml::link("支付", array('szfpay', 'id'=>$data->no));
		//	} elseif (strpos($data->charge_type, "hfbbank") === 0) {
		//		echo CHtml::link("支付", array('hfbpay', 'id'=>$data->no));
		//	} else {
		//		echo CHtml::link("支付", array('pay', 'id'=>$data->no));
		//	}
		//}
		//echo CHtml::link("删除", "#", array(
		//	'submit' => array('remove', 'id'=>$data->no)));
		//if($data->status==Charge::CREATED) {
		//	echo CHtml::link("取消", "#", array(
		//		'submit' => array('delete', 'id'=>$data->no),
		//	));
		//}
		?>
	</td>
	-->
</tr>

