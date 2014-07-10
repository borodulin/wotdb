<table id="jqgrid"></table>
<?php

$cs = Yii::app()->clientScript;

$cellAttr=<<<FUNC
function jqcCellattr(rowId, val, rawObject, cm, rdata) {
	var title=rawObject['description'];	
	return 'title="'+title+'"';
}
FUNC;

$cs->registerScript(__CLASS__. $this->getId().'1', $cellAttr, CClientScript::POS_READY);

$options=CJavaScript::encode(array(
		'datatype'=>'local',
		'data'=>RptReport::execute('bestAchievments'),
		'colNames'=>array('Игрок', 'Медаль', 'Достижение'),
		'colModel'=>array(
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left'),
			array('name'=>'name','index'=>'name','width'=>150,'align'=>'right', 'cellattr'=>'js:jqcCellattr'),
			array('name'=>'max_cnt','index'=>'max_cnt','width'=>80,'align'=>'right','sorttype'=>'number'),
		),
		'rowNum'=>1000,
	//	'rowList'=>array( 10, 20, 30 ),
		'sortname'=>'player_name',
		'sortorder'=>'asc',
		'height'=>'auto',
		'caption'=>'Достижения',
		'viewrecords'=> true,
));

$cs->registerScript($this->getId().'jqGrid', "jQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
$cs->registerPackage('jqGrid');