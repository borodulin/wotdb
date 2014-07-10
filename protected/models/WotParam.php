<?php

class WotParam extends CActiveRecord
{

	private static $_models;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getParamByName($paramName)
	{
		if(empty(self::$_models))
			self::$_models=self::model()->findAll(array('index'=>'param_name'));
		if(!isset(self::$_models[$paramName])){
			$model=new self();
			$model->param_name=$paramName;
			$model->save(false);
			self::$_models=self::model()->findAll(array('index'=>'param_name'));
		}
		return self::$_models[$paramName];
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_param';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		);
	}

}