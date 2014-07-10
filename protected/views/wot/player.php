<div class="row-fluid">
	<div class="col-md-2">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-cogs"></i>Игроки
				</div>
				<div class="tools">
					<a href="javascript:;" class="reload"></a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="scroller" data-height="700px">
<?php

$this->widget('zii.widgets.grid.CGridView',array(
	//	'type'=>array('condensed','striped','bordered'),
		'itemsCssClass'=>'table table-condensed table-striped',
		'dataProvider'=>new CArrayDataProvider(RptReport::execute('players'),array(
				'keyField'=>'player_name',
				'pagination'=>false,
		)),
	//	'filter'=>$model,
		'columns'=>array(
				array(
					'class'=>'CLinkColumn',
					'id'=>'player_name',
					'labelExpression'=>'$data["player_name"]',
					'urlExpression'=>'"javascript:chart(".$data["player_id"].",'."'".'".$data["player_name"]."'."'".')"',
				),
		),
		'htmlOptions'=>array('class'=>'portlet-body'),
		'template'=>"{items}",
		'hideHeader'=>true,
));
?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-10">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-users"></i>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-12">
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-users"></i>Динамика эффективности wot-news
								</div>
								<div class="tools">
									<a href="javascript:;" class="reload"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div id="chart_1" class="chart" style="height: 200px"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="portlet">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-users"></i>Динамика процента побед
								</div>
								<div class="tools">
									<a href="javascript:;" class="reload"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div id="chart_2" class="chart" style="height: 200px"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
	$script=<<<SCRIPT
var currentId;
function chart(playerId,playerName){
	currentId=playerId;
	var s1=[],s2=[],s3=[];
	$.ajax({
		url: '/wot/playerdata',
		method: 'GET',
		dataType: 'json',
		data: {id:playerId},
		success: function(series){
			$.each(series,function(index,value){
				s1.push([value.dd*1000,value.effect]);
				s2.push([value.dd*1000,value.wn8]);
				s3.push([value.dd*1000,value.wp]);
			});
			$.plot($("#chart_1"),
				[{data: s1, label: "рейтинг Wot-News" }, { data: s2, label: "рейтинг WN8" , yaxis: 2}],
				{
					series: {
						lines: {
							show: true
						},
						points: {
							show: true
						}
					},
					xaxis: { mode: "time", timeformat: "%d.%m.%y"},
					yaxes: [ { color: "#edc240"}, {position: 'right', color: "#afd8f8"} ],
					grid: {
						backgroundColor: {
							colors: ["#fff", "#eee"]
						},
						hoverable: true,
						clickable: true
					},
					legend: {show: true,  position: "nw", backgroundOpacity:0}
				}
			);
			$.plot($("#chart_2"),
				[{data: s3, label: "% побед" }],
				{
					series: {
						lines: {
							show: true
						},
						points: {
							show: true
						}
					},
					xaxis: { mode: "time", timeformat: "%d.%m.%y"},
					grid: {
						backgroundColor: {
							colors: ["#fff", "#eee"]
						},
						hoverable: true,
						clickable: true
					},
					legend: {show: false,  position: "nw", backgroundOpacity:0}
				}
			);
			$('#user').text(playerName);
		}
	});
}
function showTooltip(x, y, contents) {
	var tooltip = $('<div id="tooltip">' + contents + '</div>');
	tooltip.css( {
		position: 'absolute',
		display: 'none',
		top: y + 20,
		left: x - 200,
		border: '1px solid #fdd',
		padding: '2px',
		'background-color': '#fee',
		opacity: 0.80
	}).appendTo("body").fadeIn(200);
}
var previousPoint = null;
$("#chart_1,#chart_2").bind("plothover", function (event, pos, item) {
	$("#x").text(pos.x.toFixed(2));
	$("#y").text(pos.y.toFixed(2));

	if (item) {
		if (previousPoint != item.seriesIndex) {
			previousPoint = item.seriesIndex;

			$("#tooltip").remove();
			var x = item.datapoint[0].toFixed(2),
				y = item.datapoint[1].toFixed(2);

			showTooltip(item.pageX, item.pageY, item.series.label + " = " + y);
		}
	}
	else {
		$("#tooltip").remove();
		previousPoint = null;
	}
});

$("#chart_1,#chart_2").bind("plotclick", function (event, pos, item) {
	if (item) {
		var x = item.datapoint[0].toFixed(2)/1000;
		$("#tooltip").remove();
		$.ajax({
			url: '/wot/playertankdata',
			method: 'GET',
			dataType: 'json',
			data: {playerId:currentId,date:x},
			success: function(data){
				var content="";
				$.each(data,function(index,value){
					content=content+"<b>"+value.tank_localized_name+"</b> боев: "+value.bc+" побед: "+value.wc+"("+parseFloat(value.pw).toFixed(1)+"%)<br/>";
				});
				showTooltip(item.pageX, item.pageY, content);
			}
		});
	}
});
SCRIPT;
	$cs=Yii::app()->clientScript;
	$cs->registerScript(__CLASS__.$this->getId(), $script,CClientScript::POS_END);
	$cs->registerPackage('flot');
?>

