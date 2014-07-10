<?php
/**
 * @property WotPlayer[] $players
 * 
 * @author Андрей
 *
 */
class WotClan extends CActiveRecord
{
	
	private static $_clan;
	
	/**
	 * @return WotClan
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return WotClan the static model class
	 */
	public static function currentClan()
	{
		if(empty(self::$_clan)){
			if(!isset(Yii::app()->params['clan']))
				throw new CException('You need specify clan in config params');
			self::$_clan=self::model()->findByPk(Yii::app()->params['clan']);
		}
		return self::$_clan;
	}	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wot_clan';
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
			'players'=>array(self::MANY_MANY,'WotPlayer','wot_player_clan(player_id,clan_id)','condition'=>'escape_date is null', 'index'=>'player_id'),
			'playersRec'=>array(self::HAS_MANY,'WotPlayerClan','clan_id','condition'=>'escape_date is null', 'index'=>'player_id'),
			'clanProvinces'=>array(self::HAS_MANY,'WotClanProvince','clan_id', 'condition'=>'date_end is null', 'with'=>array('province'), 'index'=>'province_id'),
			'histories'=>array(self::HAS_MANY, 'WotClanHistory', 'clan_id', 'order'=>'histories.updated_at DESC', 'limit'=>50, 'on'=>'histories.updated_at<curdate()'),
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

	public function historyValues($attribute)
	{
		$result=array();
		if(!empty($this->$attribute))
			$result[]=$this->$attribute;
		foreach ($this->histories as $history){
			if(!empty($history->$attribute))
				$result[]=$history->$attribute;
		}
		return array_values(array_unique($result));
	}
	
	public function increment($attribute)
	{
		$values=$this->historyValues($attribute);
		if(count($values)>1){
			return $values[0]-$values[1]; 
		}
		return 0;
	}
}
