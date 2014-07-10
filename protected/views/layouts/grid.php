<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title><?php echo CHtml::encode($this->pageTitle); ?></title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="" name="description" />
   <meta content="" name="author" />

   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="/css/bootstrap.min.css" rel="stylesheet" />
   <link href="/css/bootstrap-responsive.min.css" rel="stylesheet" />
   <link rel="stylesheet" type="text/css" href="/css/bootstrap-fileupload.css" />
   
   <!--  link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" /-->
   <link href="/css/style.css" rel="stylesheet" />
   <link href="/css/style_responsive.css" rel="stylesheet" />
   <link href="/css/themes/default.css" rel="stylesheet" id="style_color" />
   <link href="/css/jqgrid-bs.css" rel="stylesheet" />
   <!-- link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" /-->
   <link href="#" rel="stylesheet" id="style_metro" />
   <!-- END GLOBAL MANDATORY STYLES -->

  <?php Yii::app()->clientScript->registerCoreScript('font-awesome'); ?>
  <?php // Yii::app()->clientScript->registerCoreScript('uniform'); ?>
  <?php  Yii::app()->clientScript->registerCoreScript('flot'); ?>
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<div id="header" class="navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="index.html">
				<img src="/img/logo.png" alt="Conquer" />
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="arrow"></span>
				</a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<div class="top-nav">
					<!-- BEGIN TOP NAVIGATION MENU -->
					<ul class="nav pull-right" id="top_menu">
						<li class="divider-vertical hidden-phone hidden-tablet"></li>
						<li class="divider-vertical hidden-phone hidden-tablet"></li>
						<?php if(!Yii::app()->user->isGuest):?>
						<!-- BEGIN USER LOGIN DROPDOWN -->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-user"></i>
							<?php echo Yii::app()->user->name; ?>
							<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="/site/logout"><i class="icon-key"></i> Log Out</a></li>
							</ul>
						</li>
						<!-- END USER LOGIN DROPDOWN -->
						<?php endif;?>
					</ul>
					<!-- END TOP NAVIGATION MENU -->
				</div>
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->

   <!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN SIDEBAR -->
      <div id="sidebar" class="nav-collapse collapse">
         <div class="sidebar-toggler hidden-phone"></div>
         <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
         <div class="navbar-inverse">
            <form class="navbar-search visible-phone">
               <input type="text" class="search-query" placeholder="Search" />
            </form>
         </div>
         <!-- END RESPONSIVE QUICK SEARCH FORM -->
         <!-- BEGIN SIDEBAR MENU -->
         <?php
	/*	$this->widget('ext.conquer.QSidebar', array(
 			'items'=>array(
 				// Important: you need to specify url as 'controller/action',
 				// not just as 'controller' even if default acion is used.
 				array('label'=>'Home', 'url'=>array('site/index')),
 				// 'Products' menu item will be selected no matter which tag parameter value is since it's not specified.
 				array('label'=>'Products', 'url'=>'javascript:;', 'items'=>array(
 					array('label'=>'New Arrivals', 'url'=>array('product/new', 'tag'=>'new')),
 					array('label'=>'Most Popular', 'url'=>array('product/index', 'tag'=>'popular')),
 				)),
 				array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
 			),
 		));*/ ?>
         <!-- BEGIN SIDEBAR MENU -->
         <ul>
            <li class="start ">
               <a href="<?php echo Yii::app()->createUrl('wot/index'); ?>">
               <i class="icon-home"></i>
               <span class="title">Главная</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/players'); ?>">
               <i class="icon-user"></i>
               <span class="title">Состав</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/effect'); ?>">
               <i class="icon-user"></i>
               <span class="title">Эффективность</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/progress'); ?>">
               <i class="icon-user"></i>
               <span class="title">Прогресс</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/tanks'); ?>">
               <i class="icon-user"></i>
               <span class="title">Танки</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/hangars'); ?>">
               <i class="icon-user"></i>
               <span class="title">Ангары</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/activity'); ?>">
               <i class="icon-user"></i>
               <span class="title">Активность по танкам</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/presense'); ?>">
               <i class="icon-user"></i>
               <span class="title">Посещаемость</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/player'); ?>">
               <i class="icon-user"></i>
               <span class="title">Динамика игрока</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/glory'); ?>">
               <i class="icon-user"></i>
               <span class="title">Зал славы</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/fame'); ?>">
               <i class="icon-user"></i>
               <span class="title">Герои</span>
               </a>
            </li>
			<li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/usefulness'); ?>">
               <i class="icon-user"></i>
               <span class="title">Полезность</span>
               </a>
            </li>
            <li class="">
               <a href="<?php echo Yii::app()->createUrl('wot/ts'); ?>">
               <i class="icon-user"></i>
               <span class="title">Teamspeak</span>
               </a>
            </li>
         </ul>
         <!-- END SIDEBAR MENU -->

         <!-- END SIDEBAR MENU -->
      </div>
      <!-- END SIDEBAR -->
      <!-- BEGIN PAGE -->
      <div id="body">
         <!-- BEGIN SAMPLE widget CONFIGURATION MODAL FORM-->
         <div id="widget-config" class="modal hide">
            <div class="modal-header">
               <button data-dismiss="modal" class="close" type="button"></button>
               <h3>widget Settings</h3>
            </div>
            <div class="modal-body">
               <p>Here will be a configuration form</p>
            </div>
         </div>
         <!-- END SAMPLE widget CONFIGURATION MODAL FORM-->
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                  <h3 class="page-title">
                     <?php echo CHtml::encode($this->pageTitle); ?>
                     <small></small>
                  </h3>

					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
						'links'=>$this->breadcrumbs,
					)); ?><!-- breadcrumbs -->

                  <!-- END PAGE TITLE & BREADCRUMB-->
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->

            <?php echo $content;?>

            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
   <!-- END CONTAINER -->
   <!-- BEGIN FOOTER -->
   <div id="footer">
      2013 &copy; Conquer. Admin Dashboard Template.
      <div class="span pull-right">
         <span class="go-top"><i class="icon-arrow-up"></i></span>
      </div>
   </div>
   <!-- END FOOTER -->

   <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
   <!-- BEGIN CORE PLUGINS -->
   <!--  script src="assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script-->
   <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
   <script src="/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
   <script src="/js/bootstrap.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="/js/bootstrap-fileupload.js"></script>
   
   <!--[if lt IE 9]>
   <script src="/js/excanvas.js"></script>
   <script src="/js/respond.js"></script>
   <![endif]-->
   <script src="/js/breakpoints.js" type="text/javascript"></script>
   <!-- IMPORTANT! jquery.slimscroll.min.js depends on jquery-ui-1.10.1.custom.min.js -->
   <script src="/js/jquery.slimscroll.min.js" type="text/javascript"></script>
   <script src="/js/jquery.blockui.js" type="text/javascript"></script>
   <script src="/js/jquery.cookie.js" type="text/javascript"></script>
   <script src="/js/jquery.uniform.min.js" type="text/javascript" ></script>
   <!-- END CORE PLUGINS -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <!--  script type="text/javascript" src="assets/plugins/data-tables/jquery.dataTables.js"></script -->
   <!-- script type="text/javascript" src="assets/plugins/data-tables/DT_bootstrap.js"></script -->
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="/js/app.js"></script>
   <script>
      jQuery(document).ready(function() {
         App.init();
      });
   </script>
   <!-- END JAVASCRIPTS-->
</body>
<!-- END BODY -->
</html>
