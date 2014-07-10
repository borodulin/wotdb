<?php 
	$cs=Yii::app()->clientScript;
	$cs->registerPackage('font-awesome');
	$cs->registerPackage('bootstrap');
	$cs->registerPackage('uniform');
	$cs->registerPackage('jquery-migrate');
	$cs->registerPackage('bootstrap-hover-dropdown');
	$cs->registerPackage('jquery-slimscroll');
	$cs->registerPackage('jquery-blockui');
	$cs->registerPackage('jquery-cookie');
	$cs->registerScript($this->getId().'Init','App.init();', CClientScript::POS_READY);
	$cs->registerScriptFile('/scripts/app.js', CClientScript::POS_END);
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta content="Статистика клана" name="description"/>
<meta content="K0TAFEY" name="author"/>
<meta name="MobileOptimized" content="320">

<!-- BEGIN THEME STYLES -->
<link href="/css/style-conquer.css" rel="stylesheet" type="text/css"/>
<link href="/css/style.css" rel="stylesheet" type="text/css"/>
<link href="/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/css/pages/tasks.css" rel="stylesheet" type="text/css"/>
<link href="/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="/css/custom.css" rel="stylesheet" type="text/css"/>
<!-- END THEME STYLES -->
<!--  link rel="shortcut icon" href="/favicon.ico"/ -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse navbar-fixed-top">
	<!-- BEGIN TOP NAVIGATION BAR -->
	<div class="header-inner">
		<!-- BEGIN LOGO -->
		<a class="navbar-brand" href="/">
		<img src="<?php echo WotClan::currentClan()->clan_ico;?>" alt="logo" class="img-responsive"/>
		</a>
		<!-- END LOGO -->
		<!-- BEGIN RESPONSIVE MENU TOGGLER -->
		<a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<img src="/img/menu-toggler.png" alt=""/>
		</a>
		<!-- END RESPONSIVE MENU TOGGLER -->		
		<!-- BEGIN TOP NAVIGATION MENU -->
		<ul class="nav navbar-nav pull-right">			
			<li class="devider">
				 &nbsp;
			</li>
			<?php if(!Yii::app()->user->isGuest):?>
			<!-- BEGIN USER LOGIN DROPDOWN -->
			<li class="dropdown user">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
				<img alt="" src="/img/avatar3_small.jpg"/>
				<span class="username">
					 <?php echo Yii::app()->user->name; ?>
				</span>
				<i class="fa fa-angle-down"></i>
				</a>
				<ul class="dropdown-menu">
					<li>
						<a href="/site/logout"><i class="fa fa-key"></i> Log Out</a>
					</li>
				</ul>
			</li>
		<!-- END USER LOGIN DROPDOWN -->
		<?php endif;?>
		</ul>
	<!-- END TOP NAVIGATION MENU -->
	</div>
<!-- END TOP NAVIGATION BAR -->
</div>
<!-- END HEADER -->
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<ul class="page-sidebar-menu">
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<div class="clearfix">
					</div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<?php 
					$items=$this->menu;
					$count=0;
					$n=count($items);
					foreach ($items as $action=>$menuName): 
						$count++;
						$class='';
						if($count==1) $class='start';
						elseif($count==$n) $class='last';
						if($action==$this->action->id)
							$class.=' active';
					?>
				<li class="<?php echo $class;?>">
					<a href="<?php echo $this->createUrl('wot/'.$action); ?>">
					<i class="fa <?php echo ($count==1)?'fa-home':'fa-bar-chart-o'; ?>"></i>
					<span class="title">
						<?php echo $menuName;?>
					</span>
					<span class="selected">
					</span>
					</a>
				</li>
				<?php 
					endforeach;?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
</div>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<!--	<h3 class="page-title">
					Dashboard <small>statistics and more</small>
					</h3>
				-->
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="/">Главная</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<?php if(isset($this->menu[$this->action->id])):?>
						<li>
							<span><?php echo $this->menu[$this->action->id]; ?></span>
						</li>
						<?php endif;?>
						<li class="pull-right">
							<div id="dashboard-report-range" class="dashboard-date-range tooltips" data-placement="top" data-original-title="Change dashboard date range">
								<i class="fa fa-calendar"></i>
								<span>
								</span>
								<i class="fa fa-angle-down"></i>
							</div>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<?php echo $content;?>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
</div>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/js/respond.min.js"></script>
<script src="/js/excanvas.min.js"></script> 
<![endif]-->
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>