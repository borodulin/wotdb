<?php

class WotProvince extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return WotProvince the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return WotProvince the static model class
	 */
	public static function getByAttributes($attributes)
	{
		$arena=WotArena::model()->findByPk($attributes['arena_id']);
		if(empty($arena)){
			$arena=new WotArena();
			$arena->arena_id=$attributes['arena_id'];
			$arena->arena_name=$attributes['arena_name'];
			$arena->save(false);
		}
		$model=self::model()->findByBk($attributes['province_id']);
		if(empty($model)){
			$model=new WotProvince();
			$model->province_id=$attributes['province_id'];
			$model->province_name=$attributes['name'];
			$model->arena_id=$attributes['arena_id'];
			$model->attaked=$attributes['attaked'];
			$model->occupancy_time=$attributes['occupancy_time'];
			$model->combats_running=$attributes['combats_running'];
			$model->prime_time=$attributes['prime_time'];
			$model->gold=$attributes['gold'];
			$model->save(false);
		}
		return $model;
	}	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_province';
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