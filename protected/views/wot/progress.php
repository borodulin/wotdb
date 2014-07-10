<?php
$this->pageTitle=Yii::app()->name . ' - Активность по танкам';
$this->breadcrumbs=array(
	'Активность по танкам',
);
?>

<div class="row-fluid">
	<div class="span4">
	<table id="jqgrid"></table>
<?php

$cs = Yii::app()->clientScript;

$cellAttr=<<<FUNC
function jqcCellattr(rowId, val, rawObject, cm, rdata) {
	var v=rawObject[cm.name.substr(1)], val=rawObject[cm.name];
	if(val>0)
		return 'style="color:green" title="'+v+' (+'+ val +')"';
	else if(val<0)
		return 'style="color:red" title="'+v+' ('+ val +')"';
	else
		return 'title="'+val+'"';
}
FUNC;

$formatter=<<<FUNCF
function jqcFormatter(cellvalue, options, rowObject)
{
	if(cellvalue>0)
		cellvalue='+'+cellvalue;
	var v=rowObject[options.colModel.name.substr(1)];
	return parseFloat(v).toFixed(2) +'('+cellvalue+')';
}
function jqcFormatter1(cellvalue, options, rowObject)
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
		'data'=>RptReport::execute('progress'),
		'colNames'=>array('Игрок', 'Боев', 'РЭ', 'WN8', 'Побед','Опыт','Дамаг','Фраги','Засвет','Захват','Защита','Живучесть','Точность','Макс. опыт'),
		'colModel'=>array(
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left'),
//			array('name'=>'battles_count','index'=>'battles_count','width'=>50,'align'=>'right','summaryType'=>'sum','sorttype'=>'number'),
			array('name'=>'battles_count','index'=>'battles_count','width'=>80,'align'=>'right','sorttype'=>'number'),
//			array('name'=>'tank_localized_name','index'=>'tank_localized_name','width'=>100),
//			array('name'=>'hupdated_at','index'=>'hupdated_at','width'=>90,'sorttype'=>'datetime', 'datefmt'=>'Y-m-d H:i','align'=>'right','formatter'=>'date','formatoptions'=>array('srcformat'=>'Y-m-d H:i:s','newformat'=>'d.m.Y H:i')),
//			array('name'=>'updated_at','index'=>'updated_at','width'=>90,'sorttype'=>'datetime', 'datefmt'=>'Y-m-d H:i','align'=>'right','formatter'=>'date','formatoptions'=>array('srcformat'=>'Y-m-d H:i:s','newformat'=>'d.m.Y H:i')),
			array('name'=>'heffect','index'=>'heffect','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'), //'formatter'=>'number',
			array('name'=>'hwn8','index'=>'hwn8','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hwinp','index'=>'hwinp','width'=>80,'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hbattle_avg_xp','index'=>'hbattle_avg_xp','width'=>60,'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter1'),
			array('name'=>'hdamage','index'=>'hdamage','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hfrags','index'=>'hfrags','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hspotted','index'=>'hspotted','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hcp','index'=>'hcp','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hdcp','index'=>'hdcp','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hsb','index'=>'hsb','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter'),
			array('name'=>'hhitp','index'=>'hhitp','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter1'),
			array('name'=>'hmax_xp','index'=>'hmax_xp','width'=>100, 'align'=>'right','sorttype'=>'number','cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter1'),
		),
		'rowNum'=>1000,
	//	'rowList'=>array( 10, 20, 30 ),
		'sortname'=>'heffect',
		'sortorder'=>'desc',
		'height'=>'auto',
		'caption'=>'Прогресс за последние 2 суток',
		'viewrecords'=> true,
));

$cs->registerScript($this->getId().'jqGrid', "jQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
$cs->registerPackage('jqGrid');
?>
	</div>
</div>