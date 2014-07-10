<div class="row-fluid">
	<table id="jqgrid"></table>
<?php

$cs = Yii::app()->clientScript;

$formatter=<<<FUNCF
function linkFormatter(cellvalue, options, rowObject)
{
	return '<a href="http://wot-news.com/index.php/stat/single/ru/'+cellvalue+'" target="_blank" style="text-decoration: underline;">'+cellvalue+'</a>'
}
FUNCF;

$cs->registerScript(__CLASS__. $this->getId().'2', $formatter, CClientScript::POS_READY);

$options=CJavaScript::encode(array(
		'datatype'=>'local',
		'data'=>RptReport::execute('usefulness'),
		'colNames'=>array('Игрок', 'Проц. побед', 'Кол-во топов', '300 боев'),
		'colModel'=>array(
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left','formatter'=>'js:linkFormatter'),
			array('name'=>'pp','index'=>'pp','width'=>100,'align'=>'right','formatter'=>'number','sorttype'=>'number','firstsortorder'=>'desc'),
			array('name'=>'tops','index'=>'tops','width'=>100,'align'=>'right','formatter'=>'integer','sorttype'=>'number', 'firstsortorder'=>'desc'),
		//	array('name'=>'losses','index'=>'losses','width'=>80,'align'=>'right','sorttype'=>'number'),
		//	array('name'=>'clan_role_name','index'=>'clan_role_name','width'=>140,'align'=>'right', 'firstsortorder'=>'desc'),
		//	array('name'=>'battle_avg_xp','index'=>'battle_avg_xp','width'=>80,'align'=>'right','sorttype'=>'number','firstsortorder'=>'desc'),
		//	array('name'=>'max_xp','index'=>'max_xp','width'=>80,'align'=>'right','sorttype'=>'number','firstsortorder'=>'desc'),
		//	array('name'=>'effect','index'=>'effect','width'=>80,'align'=>'right','sorttype'=>'number','formatter'=>'number','firstsortorder'=>'desc'),
		//	array('name'=>'wn6','index'=>'wn6','width'=>80,'align'=>'right','sorttype'=>'number','formatter'=>'number','firstsortorder'=>'desc'),
		//	array('name'=>'updated_at','index'=>'updated_at','width'=>110,'align'=>'right','sorttype'=>'date','firstsortorder'=>'desc','formatter'=>'date','formatoptions'=>array('srcformat'=>'Y-m-d H:i:s','newformat'=>'d.m.Y H:i')),
			array('name'=>'usefulness','index'=>'usefulness','width'=>80,'align'=>'right','formatter'=>'number','sorttype'=>'number','firstsortorder'=>'desc'),
		),
		'rowNum'=>1000,
	//	'rowList'=>array( 10, 20, 30 ),
		'sortname'=>'dcnt',
		'sortorder'=>'desc',
		'height'=>'auto',
		'caption'=>'Полезность 300 боев на топах',
		'viewrecords'=> true,
));

$cs->registerScript($this->getId().'jqGrid', "jQuery('#jqgrid').jqGrid($options);", CClientScript::POS_READY);
$cs->registerPackage('jqGrid');
?>
</div>