<?php

class ClientProperties extends CActiveRecord
{
	
	public $player_id;

	/**
	 * Returns the static model of the specified AR class.
	 * @return ClientProperties the static model class
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
		return 'client_properties';
	}

	public function getDbConnection()
	{
		return Yii::app()->dbts;
	}
}