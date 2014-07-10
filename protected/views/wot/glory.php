<table id="jqgrid"></table>
<?php

$cs = Yii::app()->clientScript;

$cellAttr=<<<FUNC
function jqcCellattr(rowId, val, rawObject, cm, rdata) {
	var v=rawObject['d'+cm.name], val=rawObject[cm.name];
	v=parseFloat(v).toFixed(0);
	if(v>0)
		return 'style="color:green" title="'+val+' (+'+ v +')"';
	else if(v<0)
		return 'style="color:red" title="'+val+' ('+ v +')"';
	else
		return 'title="'+v+'"';
}
FUNC;

$formatter=<<<FUNCF
function jqcFormatter(cellvalue, options, rowObject)
{
	if(cellvalue>0)
		cellvalue='+'+cellvalue;
	var v=rowObject[options.colModel.name.substr(1)];
	return parseFloat(v).toFixed(0) +'('+cellvalue+')';
}
FUNCF;

	$cs->registerScript(__CLASS__. $this->getId().'1', $cellAttr, CClientScript::POS_READY);
	$cs->registerScript(__CLASS__. $this->getId().'2', $formatter, CClientScript::POS_READY);


	$options=CJavaScript::encode(array(
		'datatype'=>'local',
		'data'=>RptReport::execute('gloryPosition'),
		'colNames'=>array('Игрок', 'Дней в клане', 'Должность', 'Очки славы', 'Позиция'),
		'colModel'=>array(
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left'),
			array('name'=>'days','index'=>'days','width'=>100,'align'=>'right','sorttype'=>'number','firstsortorder'=>'desc'),
			array('name'=>'clan_role_name','index'=>'clan_role_name','width'=>150,'align'=>'right'),
			array('name'=>'glory_points','index'=>'glory_points','width'=>80,'align'=>'right','sorttype'=>'number','firstsortorder'=>'desc','cellattr'=>'js:jqcCellattr'), 
			array('name'=>'glory_position','index'=>'glory_position','width'=>80,'align'=>'right','sorttype'=>'js:function(cellValue){return cellValue == 0 ? 99999999 : Number(cellValue);}','cellattr'=>'js:jqcCellattr'),
		),
		'rowNum'=>1000,
	//	'rowList'=>array( 10, 20, 30 ),
		'sortname'=>'glory_points',
		'sortorder'=>'desc',
		'height'=>'auto',
		'caption'=>'Позиция славы',
		'viewrecords'=> true,
	));

$cs->registerScript($this->getId().'jqGrid', "jQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
$cs->registerPackage('jqGrid');