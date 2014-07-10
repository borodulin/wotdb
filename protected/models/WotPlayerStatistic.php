<?php

class WotPlayerStatistic extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return WotPlayerStatistic the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_player_statistic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(
				'spotted,hits,battle_avg_xp,draws,wins,losses,capture_points,battles,damage_dealt,hits_percents,damage_received,shots,xp,frags,survived_battles,dropped_capture_points', 
				'numerical',
				'integerOnly'=>true
			),
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
			'statistic'=>array(self::BELONGS_TO, 'WotStatistic', 'statistic_id'),
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
	
	public function getStatisticName()
	{
		return $this->statistic->statistic_name;
	}
	
}