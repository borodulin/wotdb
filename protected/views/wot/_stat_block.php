<?php 
if($position<30)
	$progressClass='progress-bar-danger';
elseif($position<40)
	$progressClass='progress-bar-warning';
elseif($position<60)
	$progressClass='progress-bar-info';
else
	$progressClass='progress-bar-success';

if($increment>0)
	$pietyClass='good';
elseif($increment<0)
	$pietyClass='bad';
else
	$pietyClass='ok';
?>
<div class="col-md-2 col-sm-4">
	<div class="stats-overview stat-block">
		<div class="display stat <?php echo $pietyClass; ?> huge">
			<span class="line-chart">
				<?php echo implode(',', $historyValues); ?>
			</span>
			<div class="percent">
				<?php echo ($increment>0)?'+'.$increment:$increment;?>
			</div>
		</div>
		<div class="details">
			<div class="title">
				 <?php echo $tittle;?> 
			</div>
			<div class="numbers">
				 <?php echo $number; ?>
			</div>
		</div>
		<div class="progress">
			<span style="width: <?php echo $position ?>%;" class="progress-bar <?php echo $progressClass; ?>" aria-valuenow="<?php echo $position; ?>" aria-valuemin="0" aria-valuemax="100">
				<span class="sr-only">
					 <?php echo $position?>% Complete
				</span>
			</span>
		</div>
	</div>
</div>