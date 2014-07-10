<?php

class WotPlayerTank extends CActiveRecord
{

	public static $attrs=array('max_xp', 'max_frags', 'mark_of_mastery');

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getPlayerTank($playerId,$tankId)
	{
		$playerTank=self::model()->findByAttributes(array('player_id'=>$playerId,'tank_id'=>$tankId));
		if(empty($playerTank)){
			$playerTank=new WotPlayerTank();
			$playerTank->player_id=$playerId;
			$playerTank->tank_id=$tankId;
		}
		return $playerTank;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_player_tank';
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
			'player' => array(self::BELONGS_TO, 'WotPlayer', 'player_id'),
			'tank' => array(self::BELONGS_TO, 'WotTank', 'tank_id'),
			'statistics'=>array(self::HAS_MANY, 'WotPlayerTankStatistic', 'player_id, tank_id', 'index'=>'statisticName', 'with'=>array('statistic')),
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
	
	public function beforeSave()
	{
		if(parent::beforeSave()){
			if($this->isNewRecord){
				$this->created_at=new CDbExpression('now()');
			}
			return true;
		}
		else
			return false;
	}
	
	public function getStatistic($statName)
	{
		$stat=WotStatistic::model()->findByAttributes(array('statistic_name'=>$statName));
		if(empty($stat)){
			throw new CException('statistic is not defined!');
		}
		$playerTankStat=WotPlayerTankStatistic::model()->findByAttributes(array(
				'statistic_id'=>$stat->statistic_id,
				'player_id'=>$this->player_id,
				'tank_id'=>$this->tank_id,
		));
		if(empty($playerTankStat)){
			$playerTankStat = new WotPlayerTankStatistic();
			$playerTankStat->statistic_id=$stat->statistic_id;
			$playerTankStat->player_id=$this->player_id;
			$playerTankStat->tank_id=$this->tank_id;
		}
		return $playerTankStat;
	}
	
}