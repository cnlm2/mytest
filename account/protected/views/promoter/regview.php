<?php
/* @var $this ChargeController */
/* @var $data u */
?>
<tr class='charge <?php echo $parity?>'>
	<td class='charge'>
	<?php
		if ($daily == null) {
			if ($starttime == $endtime) {
				echo CHtml::encode($starttime);
			} else {
				echo CHtml::encode($starttime."-".$endtime);
			}
		} else {
			echo CHtml::encode($data['d']);
		}
	?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data['accounts']); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data['logins']); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data['macs']); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data['charges']); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data['fee']); ?>
	</td>
	<td class='charge'>
		<?php echo CHtml::encode($data['clicks']); ?>
	</td>
</tr>
