<?php

class WotTank extends CActiveRecord
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

	public static function getTank($name,$lname=null,$level=0,$nation=null,$class=null,$imageUrl=null)
	{

		if (preg_match("/#(.*?):(.*)/",$lname,$mathes)){
			$lname=$mathes[2];
		}
		if(empty(self::$_models))
			self::$_models=self::model()->findAll(array('index'=>'tank_name'));
		if(!isset(self::$_models[$name])){
			$tankNation=WotTankNation::model()->findByPk($nation);
			if(empty($tankNation)){
				$tankNation=new WotTankNation();
				$tankNation->tank_nation_id=$tankNation->tank_nation_name=$nation;
				$tankNation->save(false);
			}
			$tankClass=WotTankClass::model()->findByPk($class);
			if(empty($tankClass)){
				$tankClass=new WotTankClass();
				$tankClass->tank_class_id=$tankClass->tank_class_name=$class;
				$tankClass->save(false);
			}
			$tank=new WotTank();
			$tank->tank_class_id=$class;
			$tank->tank_nation_id=$nation;
			$tank->tank_name=$name;
			$tank->tank_localized_name=$lname;
			$tank->tank_level=$level;
			$tank->tank_image=$imageUrl;
			$tank->save(false);
			self::$_models=self::model()->findAll(array('index'=>'tank_name'));
		}
		else
		{
			$tank=self::$_models[$name];
			if(($tank->tank_level!=$level)||
					($tank->tank_nation_id!=$nation)||
					($tank->tank_class_id!=$class)||
					($tank->tank_localized_name!=$lname)||
					($tank->tank_image!=$imageUrl))
			{
				$tank->tank_nation_id=$nation;
				$tank->tank_name=$name;
				$tank->tank_localized_name=$lname;
				$tank->tank_level=$level;
				$tank->tank_image=$imageUrl;
				$tank->save(false);
			}
		}
		return self::$_models[$name];
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_tank';
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
				array(self::BELONGS_TO,'WotTankClass','tank_class_id'),
				array(self::BELONGS_TO,'WotTankNation','tank_nation_id'),
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