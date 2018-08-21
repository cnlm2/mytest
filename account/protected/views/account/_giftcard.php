
<tr class='giftcard <?php echo $parity?>'>
	<td class='giftcard' style="color:red;font-weight:bold;text-align:center;">
		<?php echo CHtml::encode($data->name); ?>
<?php 
		if ($data->card_id) {
			echo CHtml::encode('卡:'.$data->card_id); 
		}
?>
<?php
		if ($data->password) {
			echo CHtml::encode('密:'.$data->password);
		}
?>
	</td>
	<td>
		<?php echo CHtml::encode($data->desc); ?>
	</td>
</tr>

