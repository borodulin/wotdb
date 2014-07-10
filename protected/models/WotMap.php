<?php

class WotMap extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return WotMap the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return WotMap the static model class
	 */
	public static function getByName($mapName)
	{
		$model=self::model()->findByAttributes(array('map_name'=>$mapName));
		if(empty($model)){
			$model=new WotMap();
			$model->map_name=$mapName;
			$model->save(false);
		}
		return $model;
	}	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_map';
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