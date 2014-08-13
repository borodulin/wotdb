<?php $this->renderPartial('_levels'); ?>

<table id="jqgrid"></table>
<?php

$options=CJavaScript::encode(array(
		'datatype'=>'local',
		'data'=>RptReport::execute('tanks'),
		'colNames'=>array('Игрок', 'Танк', 'Боев', 'Побед', 'Проц. побед'),
		'colModel'=>array(
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left'),
			array('name'=>'tank_localized_name','index'=>'tank_localized_name','width'=>100, 'summaryType'=>'count', 'summaryTpl'=>'<div align="right" width="100%"><b>{0}</b></div>','sorttype'=>'number',),
			array('name'=>'battles','index'=>'battles','width'=>80,'align'=>'right','sorttype'=>'number', 'summaryType'=>'sum', 'summaryTpl'=>'<b>{0}</b>'),
			array('name'=>'wins','index'=>'wins','width'=>60,'align'=>'right','sorttype'=>'number', 'summaryType'=>'sum','summaryTpl'=>'<b>{0}</b>'),
			array('name'=>'wp','index'=>'wp','width'=>100, 'align'=>'right','sorttype'=>'number','formatter'=>'number', 'summaryType'=>'avg', 'formatter'=>'number','summaryTpl'=>'<b>{0}</b>'),
		),
		'rowNum'=>2000,
	//	'rowList'=>array( 10, 20, 30 ),
	//	'sortname'=>'js:function(){console.log(this); return "cnt";}',
		'sortorder'=>'asc',
		'height'=>'auto',
		'caption'=>'Танки',
		'viewrecords'=> true,
		'grouping'=>true,
		'groupingView'=> array(
			'groupField'=>array('player_name'),
			'groupDataSorted'=>true,
		//	'groupColumnShow'=>array(true),
		//	'groupText'=> array('<b>{0}</b> Всего танков: {player_name}','{0} Sum of totaly: {1}'),
			'groupCollapse'=>true,
			'groupOrder'=>array('asc'),
		//	'groupSummary'=>array(true, true),
			'groupSummaryPos'=>array('header'),
			'hideFirstGroupCol'=>true,			
		),
));
$cs=Yii::app()->clientScript;
$cs->registerScript($this->getId().'jqGrid', "jQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
$cs->registerPackage('jqGrid');
