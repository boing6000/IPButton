<?php
	// Set the correct class for the selected type
	if (!empty ($type)) {
		switch($type) {
			case 'button' :
				$typeCls = 'button-small';
				break;
			case 'bigbutton' :
				$typeCls = 'button-positive--filled';
				break;
			case 'bigbutton2' :
				$typeCls = 'button-important--filled';
				break;
			case 'facebook' :
				$typeCls = 'button-facebook--filled';
				break;
			case 'link' :
				$typeCls = 'link';
				break;
			default:
				$typeCls = 'button-small';
		}
	}

	$customCls = !empty($customClass) ? esc($customClass) : '';
	$customId = !empty($id) ? esc($id) : '';
	$btnText = !empty($buttonText) ? esc($buttonText) : '';
?>

<?php if (!empty($url)) :?>
	<a href="<?php echo esc($url); ?>" <?php if ($customId) : ?> id="<?php echo $customId ?>" <? endif; ?> class="<?php echo $typeCls ?> <?php echo $customCls ?>">
		<?php if (!empty($type) && $type == 'facebook') :?>
			<span class="button__text"><?php echo $btnText; ?></span>
		<?php else :?>
			<?php echo $btnText; ?>
		<?php endif; ?>
	</a>
<?php else :?>
	<span <?php if ($customId) : ?> id="<?php echo $customId ?>" <? endif; ?> class="<?php echo $typeCls ?> <?php echo $customCls ?>">
		<?php echo $btnText; ?>
	</span>
<? endif; ?>