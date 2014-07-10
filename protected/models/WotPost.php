<?php

class WotPost extends CActiveRecord
{

	public $image;
	// ... other attributes
	
	/**
	 * @return array validation rules for model attributes.
	 */	
	public function rules()
	{
		return array(
			array('image', 'file', 'types'=>'jpg, gif, png'),
			array('text','required'),
		);
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return WotPost the static model class
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
		return 'wot_post';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				array(self::BELONGS_TO,'WotPlayer','player_id'),
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