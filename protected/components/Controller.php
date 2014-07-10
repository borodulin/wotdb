<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array(
			'index'=>'Главная',
			'players'=>'Состав',
			'effect'=>'Эффективность',
			'progress'=>'Прогресс',
			'tanks'=>'Танки',
			'hangars'=>'Ангары',
			'activity'=>'Активность по танкам',
			'presense'=>'Посещаемость',
			'player'=>'Динамика игрока',
			'glory'=>'Зал славы',
			'fame'=>'Герои',
			'usefulness'=>'Полезность',
			'playerTankProblem'=>'Проблемные танки',
			'ts'=>'Teamspeak',
	);
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
}