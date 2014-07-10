<?php

class RptReport
{
	public static function getDefaultParams()
	{
		$userId= Yii::app()->user->id;
		return array(
			'clan'=>WotClan::currentClan()->clan_id,
			'player'=>Yii::app()->user->id,
		);
	} 
	
	public static function execute($reportName, $params=array())
	{
		$params=CMap::mergeArray(self::getDefaultParams(), $params);
		$fileName=__DIR__.'/sql/'.$reportName.'.sql';
		if(file_exists($fileName)){
			$sql=file_get_contents($fileName);
			$queryParams=array();
			if(preg_match_all('/\W:(\w+)/s',$sql,$matches)){
				foreach($matches[1] as $match){
					$queryParams[$match]=$params[$match];
				}
			}
			$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true, $queryParams);
			return $data;
		}
	}
	
}