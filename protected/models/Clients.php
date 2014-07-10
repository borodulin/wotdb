<?php

class Clients extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Clients the static model class
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
		return 'clients';
	}

	public function getDbConnection()
	{
		return Yii::app()->dbts;
	}
}