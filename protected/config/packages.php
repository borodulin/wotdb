<?php
return array(
	'jquery'=>array(
		'basePath'=>'ext.conquer.scripts',
		'js'=>array('jquery-1.10.2.min.js '),
	),
	'jquery.ui'=>array(
		'basePath'=>'ext.conquer.jquery-ui',
		'js'=>array('jquery-ui-1.10.3.custom.min.js'),
		'css'=>array('jquery-ui-1.10.3.custom.min.css '),
		'depends'=>array('jquery'),
	),
	'font-awesome'=>array(
		'basePath'=>'ext.conquer.font-awesome',
		'css'=>array('css/font-awesome.min.css'),
	),
	'bootstrap'=>array(
		'basePath'=>'ext.conquer.bootstrap',
		'js'=>array('js/bootstrap.min.js'),
		'css'=>array('css/bootstrap.min.css'),
		'depends'=>array('font-awesome', 'jquery.ui'),
	),
	'bootstrap-hover-dropdown'=>array(
		'basePath'=>'ext.conquer.bootstrap-hover-dropdown',
		'js'=>array('twitter-bootstrap-hover-dropdown.min.js'),
		'depends'=>array('bootstrap'),
	),
	'jquery-slimscroll'=>array(
		'basePath'=>'ext.conquer.jquery-slimscroll',
		'js'=>array('jquery.slimscroll.min.js'),
		'depends'=>array('jquery'),
	),
	'jquery-migrate'=>array(
		'basePath'=>'ext.conquer.scripts',
		'js'=>array('jquery-migrate-1.2.1.min.js'),
		'depends'=>array('jquery'),
	),
	'jquery-blockui'=>array(
		'basePath'=>'ext.conquer.scripts',
		'js'=>array('jquery.blockui.min.js'),
		'depends'=>array('jquery'),
	),
	'jquery-peity'=>array(
		'basePath'=>'ext.conquer.scripts',
		'js'=>array('jquery.peity.min.js'),
		'depends'=>array('jquery'),
	),
	'jquery-cookie'=>array(
			'basePath'=>'ext.conquer.scripts',
			'js'=>array('jquery.cokie.min.js'),
			'depends'=>array('jquery'),
	),
	'uniform'=>array(
		'basePath'=>'ext.conquer.uniform',
		'js'=>array('jquery.uniform.min.js'),
		'css'=>array('css/uniform.default.min.css'),
	),
	
		
	'breakpoints'=>array(
		'basePath'=>'ext.conquer.plugins.breakpoints',
		'js'=>array('breakpoints.js'),
		// 'css'=>array('css/font-awesome.min.css'),
		'depends'=>array('jquery'),
	),
	'flot'=>array(
		'basePath'=>'ext.conquer.flot',
		'js'=>array(
				'excanvas.min.js',
				'jquery.flot.min.js',
				'jquery.flot.time.min.js',
			//	'jquery.flot.crosshair.js',
			//	'jquery.flot.fillbetween.js',
			//	'jquery.flot.image.js',
			//	'jquery.flot.navigate.js',
			//	'jquery.flot.pie.js',
			//	'jquery.flot.resize.js',
			//	'jquery.flot.selection.js',
			//	'jquery.flot.stack.js',
			//	'jquery.flot.symbol.js',
			//	'jquery.flot.threshold.js'
		),
		'depends'=>array('jquery'),
	),
	'jqGrid'=>array(
			'basePath'=>'ext.jqGrid-master',
			'js'=>array('js/i18n/grid.locale-en.js','js/minified/jquery.jqGrid.min.js'),
			'css'=>array('css/ui.jqgrid.css', 'css/bootstrap.css'),
			'depends'=>array('jquery'),
	),
	'wysihtml'=>array(
		'basePath'=>'ext.conquer.plugins.bootstrap-wysihtml5',
		'js'=>array('wysihtml5-0.3.0.js','bootstrap-wysihtml5.js'),
		'css'=>array('wysiwyg-color.css','bootstrap-wysihtml5.css'),
		'depends'=>array('jquery'),
	),
);