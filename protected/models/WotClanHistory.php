<?php
/**
 * @property WotClan $clan
 * 
 * @author Андрей
 *
 */
class WotClanHistory extends CActiveRecord
{
	/**
	 * 
	 * @return WotClanHistory
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
		return 'wot_clan_history';
	}
	
	public function relations()
	{
		return array(
			'clan'=>array(self::BELONGS_TO, 'WotClan', 'clan_id'),
		);
	}
}