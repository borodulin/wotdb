<?php
$this->pageTitle=Yii::app()->name . ' - Посещаемость';
$this->breadcrumbs=array(
	'Посещаемость',
);
?>

<div class="row-fluid">
	<div class="span4">
	<table id="jqgrid"></table>
<?php

$cs = Yii::app()->clientScript;

$cellAttr=<<<FUNC
function jqcCellattr(rowId, val, rawObject, cm, rdata) {
	var vVal=rawObject[cm.index], title=cm.index, color="BEBEBE";
	if(vVal&1){
	    title=title+'\\nБыл онлайн';
	    color="D7E200";
	}
	if(vVal&2){
	    title=title+"\\nБыл в ТС";
	    color="5CCD00";
	}
	if(vVal&4){
	    title=title+"\\nВоевал на ГК";
	    color="9900FF";
	}
	return 'style="background-color:#'+color+';background:#'+color+'" title="'+title+'"';
}
FUNC;

$formatter=<<<FUNCF
function jqcFormatter(cellvalue, options, rowObject)
{
	return parseInt(cellvalue, 10).toString(2).replace(/0/g,'-').replace(/1/g,'+');
}
FUNCF;


	$data=RptPlayerPresense::execute('playerPresense');
	$colModel=array(
		array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left'),
		array('name'=>'clan_role_name','index'=>'clan_role_name','width'=>140,'align'=>'left'),
	);
	$colNames=array('Игрок', 'Должность');
	foreach ($data['dates'] as $date){
		$colModel[]=array('name'=>$date,'index'=>$date,'width'=>20,'align'=>'right','sorttype'=>'number', 'cellattr'=>'js:jqcCellattr','formatter'=>'js:jqcFormatter','firstsortorder'=>'desc');
		$colNames[]=date('d', strtotime($date));
	}
	$colNames[]='Очки';
	$colModel[]=array('name'=>'total','index'=>'total','width'=>40,'align'=>'right','sorttype'=>'number', 'firstsortorder'=>'desc');

	$options=CJavaScript::encode(array(
			//'url'=> $this->createUrl('wot/jqgriddata'),
			'datatype'=>'local',
			'data'=>$data['data'],
			'colNames'=>$colNames,
			'colModel'=>$colModel,
			'rowNum'=>1000,
			//	'rowList'=>array( 10, 20, 30 ),
			'sortname'=>'player_name',
			//	'sortorder'=>'desc',
			'height'=>'auto',
			'caption'=>'Посещаемость за месяц',
			'viewrecords'=> true,
	));
	$cs->registerScript($this->getId().'jqGrid', $cellAttr.$formatter."\njQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
	$cs->registerPackage('jqGrid');
?>
	</div>
</div>