<?php

class CTimeAR extends CActiveRecord
{
	
	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->c_time = new CDbExpression('now()');
			}
			return true;
		}
		else
			return false;
	}
}