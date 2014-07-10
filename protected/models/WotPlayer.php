<?php

class WotPlayer extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public static function isClanPlayer($playerId)
	{
		$player=WotPlayerClan::model()->findByAttributes(array('clan_id'=>WotClan::currentClan()->clan_id,'player_id'=>$playerId),'escape_date is null');
		return !empty($player);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_player';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array("spotted, hits_percents, capture_points, damage_dealt, frags, dropped_capture_points, wins, losses, battles_count, survived_battles, xp, battle_avg_xp, max_xp", 'numerical', 'integerOnly'=>true),
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
			'statistics'=>array(self::HAS_MANY, 'WotPlayerStatistic', 'player_id', 'index'=>'statisticName', 'with'=>array('statistic')),
			'achievments'=>array(self::HAS_MANY, 'WotPlayerAchievment', 'player_id', 'index'=>'achievmentName', 'with'=>array('achievment')),
			'stat'=>array(self::HAS_ONE, 'WotPlayerStatistic','player_id','on'=>'stat.statistic_id=1'),
			'playerClan'=>array(self::HAS_ONE, 'WotPlayerClan', 'player_id', 'on'=>'playerClan.escape_date is null and playerClan.clan_id=:clan', 'params'=>array('clan'=>WotClan::currentClan()->clan_id)),
		);
	}

	public function getStatistic($statName)
	{
		$statistic=WotStatistic::model()->findByAttributes(array('statistic_name'=>$statName));
		if(empty($statistic)){
			throw new CException('statistic is not defined!');
		}
		$playerStat=WotPlayerStatistic::model()->findByAttributes(array(
				'player_id'=>$this->player_id,
				'statistic_id'=>$statistic->statistic_id,
		));
		if(empty($playerStat)){
			$playerStat = new WotPlayerStatistic();
			$playerStat->statistic_id=$statistic->statistic_id;
			$playerStat->player_id=$this->player_id;
		}
		return $playerStat;
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		);
	}


	public static function calcRating()
	{
		$sql=<<<SQL
UPDATE wot_player wp
  JOIN 
(SELECT 
  wps.player_id, 
  (1240-1040/POWER(LEAST(a.midl,6),0.164))*wps.frags/wps.battles
  +wps.damage_dealt/wps.battles*530/(184*EXP(0.24*a.midl)+130)
  +wps.spotted/wps.battles*125
  +LEAST(wps.dropped_capture_points/wps.battles,2.2)*100
  +((185/(0.17+EXP((wps.wins/wps.battles*100-35)*-0.134)))-500)*0.45
  +(6-LEAST(a.midl,6))*-60 wn6,

  (1240-1040/POWER(LEAST(a.midl,6),0.164))*wps.frags/wps.battles
  +wps.damage_dealt/wps.battles*530/(184*EXP(0.24*a.midl)+130)
  +wps.spotted/wps.battles*125*LEAST(a.midl,3)/3
  +LEAST(wps.dropped_capture_points/wps.battles,2.2)*100
  +((185/(0.17+EXP((wps.wins/wps.battles*100-35)*-0.134)))-500)*0.45
  -((5-LEAST(a.midl,5))*125)/(1+EXP((a.midl-POWER(wps.battles/220,3/a.midl))*1.5)) wn7,
       
  wps.damage_dealt/wps.battles*(10/(a.midl+2))*(0.23+2*a.midl/100)
  +250*wps.frags/wps.battles
  +wps.spotted/wps.battles*150
  +log(1.732,wps.capture_points/wps.battles+1)*150
  +wps.dropped_capture_points/wps.battles*150 effect,
  
  980*a.rDAMAGEc + 210*a.rDAMAGEc*a.rFRAGc + 155*a.rFRAGc*a.rSPOTc + 75*a.rDEFc*a.rFRAGc + 145*LEAST(1.8,a.rWINc) wn8

  FROM wot_player_statistic wps
  JOIN (SELECT
      wpt.player_id,
      SUM(wt.tank_level * wpt.battles)/wps.battles midl,
      GREATEST(0,(wps.damage_dealt/SUM(etv.dmg*wpt.battles)-0.22)/(1-0.22)) rDAMAGEc,
      GREATEST(0,LEAST(wps.damage_dealt/SUM(etv.dmg*wpt.battles)+0.2,(wps.frags/SUM(etv.frag*wpt.battles)-0.12)/(1-0.12))) rFRAGc,
      GREATEST(0,LEAST(wps.damage_dealt/SUM(etv.dmg*wpt.battles)+0.1,(wps.spotted/SUM(etv.spot*wpt.battles)-0.38)/(1-0.38))) rSPOTc,
      GREATEST(0,LEAST(wps.damage_dealt/SUM(etv.dmg*wpt.battles)+0.1,(wps.dropped_capture_points/SUM(etv.def*wpt.battles)-0.10)/(1-0.10))) rDEFc,
      GREATEST(0,(wps.wins/SUM(etv.win/100*wpt.battles)-0.71)/(1-0.71)) rWINc
    FROM wot_player_tank wpt
    JOIN wot_player_statistic wps ON wpt.player_id = wps.player_id AND wps.statistic_id=1
    JOIN wot_tank wt ON wt.tank_id = wpt.tank_id
    LEFT JOIN wot_wn8_etv etv ON etv.IDNum=wpt.tank_id
    JOIN wot_player_clan wpc ON wpt.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
    GROUP BY wpt.player_id) a ON a.player_id = wps.player_id
    WHERE wps.statistic_id=1) a ON a.player_id=wp.player_id
  SET wp.wn6=a.wn6, wp.wn7=a.wn7, wp.wn8=a.wn8, wp.effect=a.effect
SQL;
		Yii::app()->db->createCommand($sql)->execute(array('clan'=>WotClan::currentClan()->clan_id));
	}
	
	/**
	 * @return WotPlayerGlory
	 */
	public function getGlory()
	{
		$glory=WotPlayerGlory::model()->findByPk(array('updated_at'=>new CDbExpression('curdate()'), 'player_id'=>$this->player_id));
		if(empty($glory)){
			$glory=new WotPlayerGlory();
			$glory->updated_at=new CDbExpression('curdate()');
			$glory->player_id=$this->player_id;
		}
		return $glory;
	}

}