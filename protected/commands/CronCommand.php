<?php

class CronCommand extends CConsoleCommand
{
	public function actionScan()
	{
		if(!isset(Yii::app()->params['clan']))
			throw new CException('You need specify clan in config params');
		WotService::scanClan(Yii::app()->params['clan']);
	}

	public function actionTanks()
	{
		WotService::updateTanks();
	}
	
	public function actionIndex()
	{
		echo 'hellow!';
	}
/*
	public function actionTsSync()
	{
		$sql=<<<SQLS
UPDATE teamspeak.clients c
  JOIN wot_player wp ON c.client_nickname like CONCAT(wp.player_name,'%')
  JOIN wot_player_clan wpc ON wp.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
  SET c.player_id=wp.player_id
  WHERE c.player_id IS NULL
SQLS;
		Yii::app()->db->createCommand($sql)->execute(array('clan'=>WotClan::currentClan()->clan_id));

		$clientProperties=ClientProperties::model()->findAll(array(
				'select'=>'t.*,c.player_id',
				'join'=>'JOIN clients c ON c.client_id=t.id',
				'condition'=>"t.ident='client_description' AND c.player_id IS NOT NULL",
		));

		$sql=<<<SQL
UPDATE client_properties cp
  set cp.value=:value
  WHERE cp.id=:id AND cp.ident='client_description'
SQL;

		foreach ($clientProperties as $cp) {
			$wotPlayer=WotPlayer::model()->findByPk($cp->player_id);
			$stat=$wotPlayer->getStatistic('all');
			if($stat->battles>0){
				$wins=number_format($stat->wins/$stat->battles*100,2);
				$s="$wotPlayer->player_name\nWins: $wins%\nEffect: $wotPlayer->effect\nWN6: $wotPlayer->wn6";
				$s=mb_convert_encoding($s,'UTF8','CP1252');
			//	echo $s;
				$cp->dbConnection->createCommand($sql)->execute(array('id'=>$cp->id,'value'=>$s));
			}
			//	break;
		}
	}
*/
	public function actionPresense()
	{
		Yii::import('ext.teamspeak.libraries.TeamSpeak3.*',true);//cFsOcmiR
		// connect to local server, authenticate and spawn an object for the virtual server on port 9987
		$ts3 = TeamSpeak3::factory(Yii::app()->params['tsUri']);
		$clientList = $ts3->clientList();
		
		$memberGroup=$ts3->serverGroupGetByName('MUMMI');
		if(empty($memberGroup))
			throw new CException('member group is empty');
		$friendGroup=$ts3->serverGroupGetByName('Друг');
		if(empty($friendGroup))
			throw new CException('friend group is empty');
		
		foreach ($clientList as $client){
			if(((string)$client['client_platform'])!='ServerQuery'){
				$info =$client->getInfo();
				
				$clientGroups=array();
				foreach ($client->memberOf() as $clientGroup){
					$clientGroups[$clientGroup->getId()]=$clientGroup;
				}
				
				$teamspeak=WotTeamspeak::model()->with(array('player', 'player.playerClan'))->findByPk($info['client_database_id']);
				if(empty($teamspeak)){
					if(preg_match('/^\w+/', (string)$client, $matches)){
						$playerName=$matches[0];
						$player=WotPlayer::model()->with(array('playerClan'))->findByAttributes(array('player_name'=>$playerName));
					}
				}
				else
					$player=$teamspeak->player;
				if(!empty($player))
				{
					if(empty($player->playerClan)){
						if(isset($clientGroups[$memberGroup->getId()]));{
							$client->addServerGroup($friendGroup->getId());
							$client->remServerGroup($memberGroup->getId());
						}
					}
					else
					{
						if(empty($teamspeak)){
							$teamspeak=new WotTeamspeak();
							$teamspeak->player_id=$player->player_id;
							$teamspeak->client_database_id=$info['client_database_id'];
							$teamspeak->save(false);
						}
						$sql="INSERT IGNORE INTO wot_presense(updated_at, client_database_id)VALUES(now(),{$info['client_database_id']})";
						Yii::app()->db->createCommand($sql)->execute();
					}
//						$wins=number_format($stat->wins/$stat->battles*100,2);
//						$description="\nПроцент побед: {$wins} \nWN8: {$player->wn8}\nРЭ: {$player->effect}\n";
//						$client->modifyDb(array('client_description'=>$description));
				}
				else
				{
					if(isset($clientGroups[$memberGroup->getId()]));{
						try {
							$client->remServerGroup($memberGroup->getId());
						} catch (Exception $e) {
						}
					}
					if(!isset($clientGroups[$friendGroup->getId()]));{
						try {
							$client->addServerGroup($friendGroup->getId());
						} catch (Exception $e) {
						}
					}
				}
			}
		}
	}
	
	public function actionGk()
	{
		WotService::updateClanProvinces(WotClan::currentClan());
	}

	public function actionAchievments()
	{
		WotService::updateAchievments();
	}
	
	
	public function actionIvanner()
	{
		$url=new CUrlHelper();
		if($url->execute('http://ivanerr.ru/lt/clan/'.WotClan::currentClan()->clan_id)){
			$xpath=new XmlPath($url->content);
			$query=$xpath->queryAll(array(
					'ivanner_pos'		=> '//*[@id="sidebar"]/ul/li/h2/span[1]',
				//	'ivanner_popularity' => '//*[@id="sidebar"]/ul/li/h2/span[2]',
					'ivanner_strength'	=> '//*[@id="sidebar"]/ul/li/h2/span[3]/b',
					'ivanner_firepower'	=> '//*[@id="sidebar"]/ul/li/h2/text()[3]',
					'ivanner_skill'		=> '//*[@id="sidebar"]/ul/li/h2/text()[2]',
			));
			$query=array_map(function($s){ return preg_replace('/\D/', '', $s);}, $query);
			$clan=WotClan::currentClan();
			$clan->setAttributes($query,false);
			$clan->save(false);
		}		
	}
	
	public function actionArmor()
	{
		$url=new CUrlHelper();
		if($url->execute('http://armor.kiev.ua/wot/clan/'.WotClan::currentClan()->clan_id)){
			$xpath=new XmlPath($url->content);
			$query=$xpath->queryAll(array(
					'armor_gk_pos'		=> '//*[@id="main"]/div[4]/div[6]/table[1]//tr[1]/td[2]',
					'armor_gk_val'		=> '//*[@id="main"]/div[4]/div[6]/table[1]//tr[1]/td[1]',
					'armor_random_pos'	=> '//*[@id="main"]/div[4]/div[6]/table[1]//tr[2]/td[2]',
					'armor_random_val'	=> '//*[@id="main"]/div[4]/div[6]/table[1]//tr[2]/td[1]',
			));
			foreach ($query as $key=>$val){
				$query[$key]=strtr($val, array(','=>'.',' '=>''));
			}
			$clan=WotClan::currentClan();
			$clan->setAttributes($query,false);
			$clan->save(false);
		}
	}
	
	public function actionClanStat()
	{
		$sql=<<<SQL
UPDATE wot_clan wc
  JOIN (SELECT wpc.clan_id, SUM(wps.wins)/SUM(wps.battles)*100 players_pp, SUM(wp.wn8)/COUNT(wp.player_id) players_wn8, count(1) players_count
          FROM wot_player wp
          JOIN wot_player_clan wpc ON wp.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
          JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id=1
          GROUP BY wpc.clan_id) a ON a.clan_id=wc.clan_id
  SET wc.players_pp=a.players_pp, wc.players_wn8=a.players_wn8, wc.players_count=a.players_count
SQL;
		Yii::app()->db->createCommand($sql)->execute(array('clan'=>WotClan::currentClan()->clan_id));	
	}
}
