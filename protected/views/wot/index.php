<?php
$this->pageTitle=Yii::app()->name . ' - Grid';
$this->breadcrumbs=array(
	'Grid',
);
$cs=Yii::app()->clientScript;
$cs->registerPackage('jquery-peity');
$cs->registerScriptFile('/scripts/index.js', CClientScript::POS_END);
$cs->registerScript($this->getId().'Index','Index.initPeityElements();', CClientScript::POS_READY);

?>
<!-- BEGIN OVERVIEW STATISTIC BARS-->
<div class="row stats-overview-cont">
	<?php 
		$historyValues=WotClan::currentClan()->historyValues('ivanner_pos');
		foreach ($historyValues as &$value){
			$value=(1-$value/400)*100;
		}
		$this->renderPartial('_stat_block',array(
			'increment'=>-1*WotClan::currentClan()->increment('ivanner_pos'),
			'historyValues'=>$historyValues,
			'tittle'=>'Рейтинг клана (Ivanner)',
			'position'=>(1-WotClan::currentClan()->ivanner_pos/400)*100,
			'number'=>WotClan::currentClan()->ivanner_pos,
		));
		$this->renderPartial('_stat_block',array(
			'increment'=>WotClan::currentClan()->increment('ivanner_strength'),
			'historyValues'=>WotClan::currentClan()->historyValues('ivanner_strength'),
			'tittle'=>'Сила клана (Ivanner)',
			'position'=>WotClan::currentClan()->ivanner_strength/10,
			'number'=>WotClan::currentClan()->ivanner_strength,
		));
		$this->renderPartial('_stat_block',array(
			'increment'=>WotClan::currentClan()->increment('ivanner_firepower'),
			'historyValues'=>WotClan::currentClan()->historyValues('ivanner_firepower'),
			'tittle'=>'Огневая мощь (Ivanner)',
			'position'=>WotClan::currentClan()->ivanner_firepower,
			'number'=>WotClan::currentClan()->ivanner_firepower,
		));
		$this->renderPartial('_stat_block',array(
			'increment'=>WotClan::currentClan()->increment('ivanner_skill'),
			'historyValues'=>WotClan::currentClan()->historyValues('ivanner_skill'),
			'position'=>WotClan::currentClan()->ivanner_skill,
			'tittle'=>'Скил (Ivanner)',
			'number'=>WotClan::currentClan()->ivanner_skill,				
		));
		$this->renderPartial('_stat_block',array(
			'increment'=>WotClan::currentClan()->increment('players_count'),
			'historyValues'=>WotClan::currentClan()->historyValues('players_count'),
			'position'=>WotClan::currentClan()->players_count,
			'tittle'=>'Кол-во игроков',
			'number'=>WotClan::currentClan()->players_count,
		));
		$this->renderPartial('_stat_block',array(
			'increment'=>number_format(WotClan::currentClan()->increment('players_wn8'), 2),
			'historyValues'=>WotClan::currentClan()->historyValues('players_wn8',2900),
			'position'=>WotClan::currentClan()->players_wn8/2900*100,
			'tittle'=>'Wn8 клана',
			'number'=>WotClan::currentClan()->players_wn8,
		));
	?>	
</div>
<div class="clearfix">
</div>
<!-- END OVERVIEW STATISTIC BARS-->
<div class="row-fluid">
	<div class="col-md-4">
		<!-- BEGIN SAMPLE TABLE widget-->
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Топ 5 по эффективности
				</div>
			</div>
			<div class="portlet-body">
			<?php
$this->widget('zii.widgets.grid.CGridView',array(
	//	'type'=>array('condensed','striped','bordered'),
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('top5effect'),array(
				'keyField'=>'player_name',
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'header'=>'Имя',
						'class'=>'CLinkColumn',
						'id'=>'player_name',
						'labelExpression'=>'$data["player_name"]',
						'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
						'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				'effect',
		),
		'htmlOptions'=>array('class'=>'widget-body'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
			?>
			</div>
		</div>
	<!-- END SAMPLE TABLE widget-->
	</div>
	<div class="col-md-4">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Топ 5 по урону
				</div>
			</div>
			<div class="portlet-body">
			<?php
$this->widget('zii.widgets.grid.CGridView',array(
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('top5damage'),array(
				'keyField'=>'player_name',
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'header'=>'Имя',
						'class'=>'CLinkColumn',
						'id'=>'player_name',
						'labelExpression'=>'$data["player_name"]',
						'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
						'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				'dmg',
		),
		'htmlOptions'=>array('class'=>'widget-body'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
			?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="portlet portlet-tabs">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Топ 5
				</div>
			</div>
			<div class="portlet-body">
				<div class="tabbable portlet-tabs">
					<ul class="nav nav-tabs">
						<li class=""><a href="#portlet_tab2" data-toggle="tab">По захвату</a></li>
						<li class=""><a href="#portlet_tab3" data-toggle="tab">По засвету</a></li>
						<li class="active"><a href="#portlet_tab1" data-toggle="tab">По защите</a></li>
					</ul>
					<div class="tab-content">
					<?php
$this->widget('zii.widgets.grid.CGridView',array(
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('top5defense'),array(
				'keyField'=>'player_name',
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'header'=>'Имя',
						'class'=>'CLinkColumn',
						'id'=>'player_name',
						'labelExpression'=>'$data["player_name"]',
						'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
						'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				'defense',
		),
		'id'=>"portlet_tab1",
		'htmlOptions'=>array('class'=>'tab-pane active'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
			?>

			<?php
$this->widget('zii.widgets.grid.CGridView',array(
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('top5capture'),array(
				'keyField'=>'player_name',
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'header'=>'Имя',
						'class'=>'CLinkColumn',
						'id'=>'player_name',
						'labelExpression'=>'$data["player_name"]',
						'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
						'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				'capture',
		),
		'id'=>'portlet_tab2',
		'htmlOptions'=>array('class'=>'tab-pane'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
			?>

						<?php
$this->widget('zii.widgets.grid.CGridView',array(
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('top5spotted'),array(
				'keyField'=>'player_name',
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'header'=>'Имя',
						'class'=>'CLinkColumn',
						'id'=>'player_name',
						'labelExpression'=>'$data["player_name"]',
						'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
						'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				'spotted',
		),
		'id'=>'portlet_tab3',
		'htmlOptions'=>array('class'=>'tab-pane'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
			?>

					</div>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="col-md-4">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Новые игроки
				</div>
			</div>
			<div class="portlet-body">
			<?php
$this->widget('zii.widgets.grid.CGridView',array(
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('newMembers'),array(
				'keyField'=>'player_name',
				'pagination'=>false,
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'header'=>'Имя',
						'class'=>'CLinkColumn',
						'id'=>'player_name',
						'labelExpression'=>'$data["player_name"]',
						'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
						'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				'entry_date',
				'clan_role_name',
				'days',
		),
		'htmlOptions'=>array('class'=>'widget-body'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
			?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Ушедшие игроки
				</div>
			</div>
			<div class="portlet-body">
			<?php
$this->widget('zii.widgets.grid.CGridView',array(
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('escapedMembers'),array(
				'keyField'=>'player_name',
				'pagination'=>false,
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
					'class'=>'CLinkColumn',
					'id'=>'player_name',
					'labelExpression'=>'$data["player_name"]',
					'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
					'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				'escape_date',
				'clan_role_name',
				'days',
		),
		'htmlOptions'=>array('class'=>'widget-body'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
			?>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Карьера
				</div>
			</div>
			<div class="portlet-body">
			<?php
$this->widget('zii.widgets.grid.CGridView',array(
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('career'),array(
				'keyField'=>'player_name',
				'pagination'=>false,
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
						'header'=>'Имя',
						'class'=>'CLinkColumn',
						'id'=>'player_name',
						'labelExpression'=>'$data["player_name"]',
						'urlExpression'=>'"http://wot-news.com/index.php/stat/single/ru/".$data["player_name"]',
						'linkHtmlOptions'=>array('target'=>'_blank'),
				),
				array('name'=>'updated_at','header'=>'Дата'),
				array('name'=>'old_role','header'=>'Был'),
				array('name'=>'clan_role_name','header'=>'Стал'),
		),
		'htmlOptions'=>array('class'=>'widget-body'),
		'template'=>"{items}",
	//	'hideHeader'=>true,
));
			?>
			</div>
		</div>
	</div>
</div>


<?php

/*
$this->widget('ext.jqgrid.JQGrid',
	array('options'=>array(
		'url'=> $this->createUrl('wot/jqgriddata'),
		'datatype'=>'local',
		'data'=>WotReport::report(),
		'colNames'=>array('Игрок', 'Боев', 'Танк', 'Начиная с','По','Всего боев','Побед','Процент побед'),
		'colModel'=>array(
			array('name'=>'player_name','index'=>'player_name','width'=>140,'align'=>'left'),
			array('name'=>'b','index'=>'b','width'=>50,'align'=>'right','summaryType'=>'sum','sorttype'=>'number'),
			array('name'=>'tank_localized_name','index'=>'tank_localized_name','width'=>100),
			array('name'=>'hupdated_at','index'=>'hupdated_at','width'=>90,'sorttype'=>'datetime', 'datefmt'=>'Y-m-d H:i','align'=>'right','formatter'=>'date','formatoptions'=>array('srcformat'=>'Y-m-d H:i:s','newformat'=>'d.m.Y H:i')),
			array('name'=>'updated_at','index'=>'updated_at','width'=>90,'sorttype'=>'datetime', 'datefmt'=>'Y-m-d H:i','align'=>'right','formatter'=>'date','formatoptions'=>array('srcformat'=>'Y-m-d H:i:s','newformat'=>'d.m.Y H:i')),
			array('name'=>'battle_count','index'=>'battle_count','width'=>80,'align'=>'right','sorttype'=>'number'),
			array('name'=>'win_count','index'=>'win_count','width'=>60,'align'=>'right','sorttype'=>'number'),
			array('name'=>'wp','index'=>'wp','width'=>100, 'align'=>'right','sorttype'=>'number','formatter'=>'number'),
		),
		'rowNum'=>1000,
	//	'rowList'=>array( 10, 20, 30 ),
		'sortname'=>'b',
		'sortorder'=>'desc',
		'height'=>'auto',
		'caption'=>'Статистика активных игроков',
		'viewrecords'=> true,
		'grouping'=>true,
		'groupingView'=> array(
			'groupField'=>array('player_name'),
			'groupColumnShow'=>array(true),
			'groupText'=> array('<b>{0}</b> Всего боев: {b}','{0} Sum of totaly: {b}'),
			'groupCollapse'=>true,
			'groupOrder'=>array('asc'),
		//	'groupSummary'=>array(false, false),
		),
)));
*/