<?php

class WotClanRole extends CActiveRecord
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


	public static function getRoleId($roleId, $role_i18n)
	{
		if(empty(self::$_models))
			self::$_models=self::model()->findAll(array('index'=>'clan_role_id'));
		if(!isset(self::$_models[$roleId])){
			$model=new self();
			$model->clan_role_id=$roleId;
			$model->clan_role_name=$role_i18n;
			$model->save(false);
			self::$_models=self::model()->findAll(array('index'=>'clan_role_id'));
		}
		return self::$_models[$roleId]->clan_role_id;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_clan_role';
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