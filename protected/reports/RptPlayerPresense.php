<?php

class RptPlayerPresense extends RptReport
{
	public static function execute($reportName='playerPresense', $params=array())
	{
		
		$dates=array();
		for ($i = date('t'); $i >0; $i--) {
			$date = date_create('now');
			date_add($date, date_interval_create_from_date_string("-$i days"));
			$dates[]=date_format($date, 'Y-m-d');
		}
		
		$data=parent::execute($reportName, $params);
		
		$result=array();
		$names=array();
		
		foreach ($data as $row){
			if(!isset($result[$row['player_id']])){
				$result[$row['player_id']]=array('player_name'=>$row['player_name'],'clan_role_name'=>$row['clan_role_name']);
				foreach ($dates as $date){
					$result[$row['player_id']][$date]=0;
				}
				$result[$row['player_id']]['total']=0;
			}
			if(in_array($row['dte'],$dates)){
				$pres=0;			
				if($row['ab']>0)
					$pres=1;
				if(!empty($row['dts']))
					$pres=$pres+2;
				if($row['gb']>0)
					$pres=$pres+4;
				
				if($pres>0)
					$result[$row['player_id']][$row['dte']]=$pres;
				$coins=0;
				if($row['ab']>0){
					if(empty($row['dts'])&&($row['gb']==0))
						$coins=-1;
					else{
						if(!empty($row['dts']))
							$coins++;
						if($row['gb']>0)
							$coins++;
					}
				}
				$result[$row['player_id']]['total']+=$coins;
			}
		}
		$res=array();
		foreach ($result as $row){
			$res[]=$row;
		}
		return array('data'=>$res,'dates'=>$dates);
	}
}