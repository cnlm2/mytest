<?php
/* @var $this ChargeController */
/* @var $data u */
?>
<tr class='charge <?php echo $parity?>'>
	<td class='charge'>
		<?php echo CHtml::encode($data->account); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->charid); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->name); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->birthday); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->grade); ?>
	</td>
	<td class='charge'>
		<?php
			$schoolNameArray = array("无门派","少林寺","丐帮","唐门","恶人谷","移花宫","武当派","白鹿书院","天山派");
			echo CHtml::encode($schoolNameArray[$data->school]);
		?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->consume); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data->vip); ?>
	</td>
</tr>
