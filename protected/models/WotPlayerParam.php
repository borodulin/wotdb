<?php

class WotPlayerParam extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function setPlayerParamValue($playerId,$paramName,$value)
	{
		$wotParam=WotParam::getParamByName($paramName);
		$playerParam=self::model()->findByAttributes(array('player_id'=>$playerId,'param_id'=>$wotParam->param_id));
		if(empty($playerParam)){
			$playerParam=new WotPlayerParam();
			$playerParam->player_id=$playerId;
			$playerParam->param_id=$wotParam->param_id;
		}
		$playerParam->value=$value;
		$playerParam->save(false);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_player_param';
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