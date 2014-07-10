<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>
<div class="span12">
<h2>Нажмите на иконку для входа через WorldOfTanks:</h2>
<?php
	$this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login'));
?>
</div>