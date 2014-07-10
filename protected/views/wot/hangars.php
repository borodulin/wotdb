
<table id="jqgrid"></table>
<?php

$options=CJavaScript::encode(array(
		'datatype'=>'local',
		'data'=>RptReport::execute('tanks'),
		'colNames'=>array('Игрок', 'Танк', 'Боев', 'Побед', 'Процент побед'),
		'colModel'=>array(
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left','summaryType'=>'count'),
			array('name'=>'tank_localized_name','index'=>'tank_localized_name','width'=>100),
			array('name'=>'battles','index'=>'battles','width'=>80,'align'=>'right','sorttype'=>'number'),
			array('name'=>'wins','index'=>'wins','width'=>60,'align'=>'right','sorttype'=>'number'),
			array('name'=>'wp','index'=>'wp','width'=>100, 'align'=>'right','sorttype'=>'number','formatter'=>'number'),
		),
		'rowNum'=>1000,
	//	'rowList'=>array( 10, 20, 30 ),
	//	'sortname'=>'js:function(){console.log(this); return "cnt";}',
	//	'sortorder'=>'desc',
		'height'=>'auto',
		'caption'=>'Танки',
		'viewrecords'=> true,
		'grouping'=>true,
		'groupDataSorted'=>false,
		'groupingView'=> array(
			'groupField'=>array('player_name'),
			'groupColumnShow'=>array(true),
			'groupText'=> array('<b>{0}</b> Всего танков: {player_name}','{0} Sum of totaly: {b}'),
			'groupCollapse'=>true,
			'groupOrder'=>array('desc'),
			'groupSummary'=>array(false, false),
		),
));
$cs=Yii::app()->clientScript;
$cs->registerScript($this->getId().'jqGrid', "jQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
$cs->registerPackage('jqGrid');
