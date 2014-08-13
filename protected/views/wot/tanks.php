<?php $this->renderPartial('_levels'); ?>

<table id="jqgrid"></table>
<?php

$options=CJavaScript::encode(array(
		'datatype'=>'local',
		'data'=>RptReport::execute('tanks'),
		'colNames'=>array('Танк', 'Бойцы', 'Боев(сред.)', 'Проц. побед'),
		'colModel'=>array(
			array('name'=>'tank_localized_name','index'=>'tank_localized_name','width'=>140),
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left','summaryType'=>'count', 'summaryTpl'=>'<div align="right" width="100%"><b>{0}</b></div>','sorttype'=>'number',),
			array('name'=>'battles','index'=>'battles','width'=>100,'align'=>'right','sorttype'=>'number', 'summaryType'=>'avg', 'summaryTpl'=>'<b>{0}</b>', 'formatter'=>'number'),
			array('name'=>'wp','index'=>'wp','width'=>100, 'align'=>'right','sorttype'=>'number','formatter'=>'number', 'summaryType'=>'avg', 'summaryTpl'=>'<b>{0}</b>'),
		),
		'rowNum'=>2000,
	//	'rowList'=>array( 10, 20, 30 ),
		'sortname'=>'wp',
		'sortorder'=>'desc',
		'height'=>'auto',
		'caption'=>'Танки',
		'viewrecords'=> true,
		'grouping'=>true,
		'groupingView'=> array(
			'groupField'=>array('tank_localized_name'),
			'groupColumnShow'=>array(true),
			'groupCollapse'=>true,
			'groupOrder'=>array('asc'),
		//	'groupSummary'=>array(false, false),
			'groupSummaryPos'=>array('header'),
			'hideFirstGroupCol'=>true,
		),
));
$cs=Yii::app()->clientScript;
$cs->registerScript($this->getId().'jqGrid', "jQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
$cs->registerPackage('jqGrid');