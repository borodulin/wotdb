<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);

Yii::app()->clientScript->registerCssFile('/css/pages/error.css');

?>
<div class="span12">
<?php if(strncmp($code,'4',1)==0): ?>
	<div class="row-fluid page-404">
		<div class="span5 number">
			<?php echo $code; ?>
		</div>
		<div class="span7 details">
			<h3>Произошла ошибка.</h3>
			<p>
				<?php echo $message;?>
			</p>
		</div>
	</div>
<?php elseif(strncmp($code,'5',1)==0): ?>
	<div class="row-fluid page-500">
		<div class="span5 number">
			500
		</div>
		<div class="span7 details">
			<h3>Opps, Something went wrong.</h3>
			<p>
				We are fixing it!<br />
				Please come back in a while.<br />
			</p>
		</div>
	</div>
<?php else: ?>
	<div class="row-fluid page-404">
		<div class="span5 number">
			<?php echo $code;?>
		</div>
		<div class="span7 details">
			<h3>Opps, You're lost.</h3>
			<p>
				<?php echo CHtml::encode($message); ?>
			</p>
		</div>
	</div>
<?php endif;?>
</div>