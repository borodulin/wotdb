<?php
class WotService
{
/*
	static private $host='worldoftanks.ru';
	static private $clanUrlJson='/uc/clans/{clanId}/members/?type=table';
	static private $playerUrlJson="http://worldoftanks.ru/community/accounts/{playerId}/";
*/

	//https://gist.github.com/2724734

//	static private $wotApiClanUrl="http://worldoftanks.ru/community/clans/{clanId}/api/1.1/?source_token=WG-WoT_Assistant-1.2.2";
//	static private $wotApiPlayerUrl="http://worldoftanks.ru/community/accounts/{playerId}/api/1.7/?source_token=WG-WoT_Assistant-1.2.2";
//	static private $applicationId='9a86259f976b45dccaacedaae1a5f441';
	static private $wotApiClanUrl="http://api.worldoftanks.ru/wot/clan/info/?application_id={applicationId}&language=ru&clan_id={clanId}";
	static private $wotApiPlayerUrl="http://api.worldoftanks.ru/wot/account/info/?application_id={applicationId}&language=ru&account_id={playerId}";
	static private $wotApiPlayerTankStat="http://api.worldoftanks.ru/wot/tanks/stats/?application_id={applicationId}&language=ru&account_id={playerId}";
	static private $wotApiTanks="http://api.worldoftanks.ru/wot/encyclopedia/tanks/?application_id={applicationId}&language=ru";
	static private $wotApiAchievments="http://api.worldoftanks.ru/2.0/encyclopedia/achievements/?application_id=9a86259f976b45dccaacedaae1a5f441&language=ru";
	static private $wotApiPlayerTanks="http://api.worldoftanks.ru/wot/account/tanks/?application_id={applicationId}&language=ru&account_id={playerId}";

	static function getApplicationId()
	{
		if(!isset(Yii::app()->params['application_id']))
			throw new CException('You need specify Wargaming application id. go to http://ru.wargaming.net/developers/ to get it');
		return Yii::app()->params['application_id'];
	}
	
	static private function tryContent($url)
	{
		$ch=curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$content=curl_exec($ch);
		if (curl_errno($ch)) {
			$content=false;
		}
		curl_close($ch);
		return $content;
	}

	static private function getContent($url)
	{
		$retryCnt=0;
		$result=self::tryContent($url);
		while(($result==false)&&($retryCnt<3)){
			$retryCnt++;
			sleep(3);
			$result=self::tryContent($url);
		}
		if($result==false){
			Yii::log('Ошибка получения статистики','error');
		}
		return $result;
	}

	
	static private function ajaxRequest($url)
	{
		$ch = curl_init();
		$timeout = 10;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				"Accept:application/json, text/javascript, */*",
			//	"Accept: text/html, */*",
				"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.95 Safari/537.36",
				"Connection: Keep-Alive",
				"X-Requested-With: XMLHttpRequest",
		));
		$data = curl_exec($ch);
		$err = curl_errno($ch);
		$errmsg = curl_error($ch) ;
		curl_close($ch);
		if($err == 0){
			return (json_decode(trim($data), true));
		}else{
			return array();
		}
	}
	

	static private function doRequestJSON($url)
	{
		$host=self::$host;
		$error = 0;
		$data = array();
        $request = "GET $url HTTP/1.0\r\n";
        $request.= "Accept: text/html, */*\r\n";
        $request.= "User-Agent: Mozilla/3.0 (compatible; easyhttp)\r\n";
        $request.= "X-Requested-With: XMLHttpRequest\r\n";
        $request.= "Host: $host\r\n";
        $request.= "Connection: Keep-Alive\r\n";
        $request.= "\r\n";
		$n = 0;
		while(!isset($fp)){
			$fp = fsockopen($host, 80, $errno, $errstr, 15);
			if($n == 3){
				break;
			}
			$n++;
		}
		if (!$fp)
		{
			return "$errstr ($errno)<br>\n";
		} else
		{
			stream_set_timeout($fp,20);
			$info = stream_get_meta_data($fp);
			fwrite($fp, $request);
			$page = '';
			while (!feof($fp) && (!$info['timed_out']))
			{
				$page .= fgets($fp, 4096);
				$info = stream_get_meta_data($fp);
			}
			fclose($fp);
			if ($info['timed_out']) {
				$error = 1; //Connection Timed Out
			}
		}
		if($error == 0){
			preg_match("/{\"request(.*?)success\"}/", $page, $matches);
			$data = (json_decode($matches[0], true));
		}
		else
			return $error;
		return $data;
	}

	/**
	 * 
	 * @param WotClan $clan
	 */
	static public function updateClanInfo($clan)
	{
		$url=strtr(self::$wotApiClanUrl, array('{applicationId}'=>self::getApplicationId(), '{clanId}'=>$clan->clan_id));
		$jsonString= self::getContent($url);
		if($jsonString!=false){
			$jsonData=json_decode($jsonString,true);
			if($jsonData['status']=='ok'){
				if(isset($jsonData['data'][$clan->clan_id])){
					$data=$jsonData['data'][$clan->clan_id];
					$clan->clan_descr=$data['description'];
					$clan->updated_at=date('Y-m-d H:i',$data['updated_at']);
					$clan->clan_name=$data['abbreviation'];
					$clan->clan_fullname=$data['name'];
					$clan->clan_descr_html=$data['description_html'];
					$clan->clan_created=date('Y-m-d', $data['created_at']);
					$clan->clan_ico=$data['emblems']['large'];
					$clan->clan_motto=$data['motto'];
					$clan->clan_owner_id=$data['owner_id'];
					$clan->save(false);
					
					$members=$data['members'];
				//	foreach ($data['members'] as $member) {
				//		$members[$member['account_id']]=$member;
				//	}
				}
				
				

				$tran=Yii::app()->db->beginTransaction();

				$clanPlayers=$clan->playersRec;
				foreach ($clanPlayers as $playerId=>$clanPlayerRec){
					if(!isset($members[$playerId]))// Покинул клан
					{
						$clanPlayerRec->escape_date=new CDbExpression('now()');
						$clanPlayerRec->save(false);
						continue;
					}
					if($clanPlayerRec->clan_role_id!=$members[$playerId]['role']){
						$clanPlayerRec->clan_role_id=WotClanRole::getRoleId($members[$playerId]['role'], $members[$playerId]['role_i18n']);
						$clanPlayerRec->save(false);
					}
				}
				foreach ($members as $playerId=>$playerData){
					if(!isset($clanPlayers[$playerId])) //Новый член клана
					{
						$player=WotPlayer::model()->findByPk($playerId);
						if(empty($player)){
							$player=new WotPlayer();
							$player->player_id=$playerId;
							$player->player_name=$playerData['account_name'];
							$player->save(false);
						}
						$playerClan = WotPlayerClan::model()->findByPk(array('player_id'=>$playerId,'clan_id'=>$clan->clan_id,'entry_date'=>date('Y-m-d' ,$playerData['created_at'])));
						if(empty($playerClan)){
							$playerClan=new WotPlayerClan();
							$playerClan->clan_id=$clan->clan_id;
							$playerClan->player_id=$playerId;
							$playerClan->entry_date=date('Y-m-d' ,$playerData['created_at']);
							$playerClan->clan_role_id=WotClanRole::getRoleId($playerData['role'], $playerData['role_i18n']);
						}
						else
						{
							if(!empty($playerClan->escape_date))
								$playerClan->escape_date=null;
						}
						$playerClan->save(false);
					}
				}

				$tran->commit();
			}
			else
				Yii::log($jsonString,'error');
				//var_dump($jsonData);
		}
	}
	
	static public function updateTanks()
	{
		$jsonString=self::getContent(str_replace('{applicationId}', self::getApplicationId(), self::$wotApiTanks));
		if($jsonString!=false){
			$jsonData=json_decode($jsonString,true);
			if($jsonData['status']=='ok'){
				$tran=Yii::app()->db->beginTransaction();
				$tanks=WotTank::model()->findAll(array('index'=>'tank_id'));
				$nations=WotTankNation::model()->findAll(array('index'=>'tank_nation_id'));
				$classes=WotTankClass::model()->findAll(array('index'=>'tank_class_id'));
				foreach ($jsonData['data'] as $data){
					if(!isset($nations[$data['nation']])){
						$nation=new WotTankNation();
						$nation->tank_nation_id=$data['nation'];
						$nation->tank_nation_name=$data['nation_i18n'];
						$nation->save(false);
						$nations[$data['nation']]=$nation;
					}
					if(!isset($classes[$data['type']])){
						$class=new WotTankClass();
						$class->tank_class_id=$data['type'];
						$class->tank_class_name=$data['type_i18n'];
						$class->save(false);
						$classes[$data['type']]=$class;
					}
					if(!isset($tanks[$data['tank_id']])){
						$tank=new WotTank();
					}
					else
						$tank=$tanks[$data['tank_id']];
					$tank->tank_id=$data['tank_id'];
					$tank->tank_class_id=$data['type'];						
					$tank->tank_nation_id=$data['nation'];
					$tank->tank_level=$data['level'];
					$tank->is_premium=$data['is_premium'];
					if (preg_match("/#(.*?):(.*)/",$data['name'],$mathes)){
						$tankName=$mathes[2];
					}
					else
						$tankName=$data['name'];
					$tank->tank_name=$tankName;
					$tank->tank_name_i18n=$data['name_i18n'];
					$tank->save(false);
				}
				$tran->commit();
			}
		}
	}
	
	static public function updateAchievments()
	{
		$jsonString=self::getContent(self::$wotApiAchievments);
		if($jsonString!=false){
			$jsonData=json_decode($jsonString,true);
			if($jsonData['status']=='ok'){
				$tran=Yii::app()->db->beginTransaction();
				$achievments=WotAchievment::model()->findAll(array('index'=>'achievment_name'));
				foreach ($jsonData['data'] as $key=>$data){
					if(!isset($achievments[$key])){
						$achievment=new WotAchievment();
						$achievment->achievment_name=$key;
					}else{
						$achievment=$achievments[$key];
					}
					$achievment->name=$data['name'];
					$achievment->type=$data['type'];
					$achievment->section=$data['section'];
					$achievment->image=$data['image'];
					$achievment->description=$data['description'];
					$achievment->save(false);
					if(is_array($data['variants'])){
						foreach($data['variants'] as $key=>$variant){
							$achievmentVariant=WotAchievmentVariant::model()->findByAttributes(array('achievment_id'=>$achievment->achievment_id,'variant_id'=>$key));
							if(empty($achievmentVariant)){
								$achievmentVariant=new WotAchievmentVariant();
								$achievmentVariant->achievment_id=$achievment->achievment_id;
								$achievmentVariant->variant_id=$key;
								$achievmentVariant->name=$variant['name'];
								$achievmentVariant->image=$variant['image'];
								$achievmentVariant->save(false);
							}
						}
					}
				}
				$tran->commit();
			}
		}
	}
	
	
	static public function updatePlayerTanks($player)
	{
		$jsonString=self::getContent(strtr(self::$wotApiPlayerTankStat, array(
				'{playerId}'=>$player->player_id,
				'{applicationId}'=>self::getApplicationId(),
		)));
		if($jsonString!=false){
			$jsonData=json_decode($jsonString,true);
			if($jsonData['status']=='ok'){
				$tran=Yii::app()->db->beginTransaction();
				foreach ($jsonData['data'][$player->player_id] as $vehicle){
				    if($vehicle['all']['battles']>0){
						$playerTank=WotPlayerTank::getPlayerTank($player->player_id, $vehicle['tank_id']);
						foreach (WotPlayerTank::$attrs as $attr) {
							$playerTank->$attr=$vehicle[$attr];
						}
						$playerTank->battles=$vehicle['all']['battles'];
						$playerTank->wins=$vehicle['all']['wins'];
						$playerTank->updated_at=$player->updated_at;
						$playerTank->mark_of_mastery=$vehicle['mark_of_mastery'];
						$playerTank->in_garage=$vehicle['in_garage'];
						$playerTank->save(false);
						foreach (array('all', 'clan', 'company', 'historical') as $statName){
						    if(isset($vehicle[$statName])&&($vehicle[$statName]['battles']>0)){
							$stat=$playerTank->getStatistic($statName);
							$stat->attributes=$vehicle[$statName];
							$stat->updated_at=$player->updated_at;
							$stat->save(false);
						    }
						}
				    }
				}
				$tran->commit();
			}
		}
	}

	static public function scanClan($clanId)
	{
		self::updateTanks();
		
		$clan=WotClan::model()->findByPk($clanId);
		if(empty($clan)){
			$clan=new WotClan();
			$clan->clan_id=$clanId;
		}
		self::updateClanInfo($clan);
		self::updateClanPlayersInfo($clan);
		$clan->refresh();
		foreach ($clan->players as $player){
			self::updatePlayerTanks($player);
			self::updatePlayerGlory($player);
		}
		WotPlayer::calcRating();
	}

	/**
	 * 
	 * @param WotClan $clan
	 */
	static public function updateClanPlayersInfo($clan)
	{
		$url=strtr(self::$wotApiPlayerUrl, array(
				'{applicationId}'=>self::getApplicationId(), 
				'{playerId}'=>implode(',', array_keys($clan->players))
		));
		$jsonString= self::getContent($url);
		if($jsonString!=false){
			$jsonData=json_decode($jsonString,true);
			if($jsonData['status']=='ok'){
		
				$tran=Yii::app()->db->beginTransaction();
				foreach ($jsonData['data'] as $playerId=>$data){
					$player=$clan->players[$playerId];
					$achievments=$player->achievments;
					$player->updated_at=date('Y-m-d H:i',$data['updated_at']);
					foreach ($data['achievements'] as $key=>$value){
						if($value>0){
							if(isset($achievments[$key])){
								$playerAchievment=$achievments[$key];
							}else{
								$achievment=WotAchievment::achievment($key);
								$playerAchievment=new WotPlayerAchievment();
								$playerAchievment->achievment_id=$achievment->achievment_id;
								$playerAchievment->player_id=$player->player_id;
									
							}
							if($playerAchievment->cnt!=$value){
								$playerAchievment->cnt=$value;
								$playerAchievment->updated_at=$player->updated_at;
								$playerAchievment->save(false);
							}
						}
					}
					foreach (array('all', 'clan', 'company', 'historical') as $statName){
						$stat=$player->getStatistic($statName);
						$stat->attributes=$data['statistics'][$statName];
						$stat->updated_at=$player->updated_at;
						$stat->save(false);
					}
					$player->max_xp=$data['statistics']['max_xp'];
					$player->created_at=date('Y-m-d H:i',$data['created_at']);
					$player->player_name=$data['nickname'];
					$player->last_battle_time=date('Y-m-d H:i',$data['last_battle_time']);
					$player->logout_at=date('Y-m-d H:i',$data['logout_at']);
					$player->global_rating=$data['global_rating'];
					$player->save(false);
				}
				$tran->commit();
			}
			else
				Yii::log($jsonString,'error');
			//	var_dump($jsonData);
		}
	}
	
	/**
	 *
	 * @param WotClan $clan
	 */
	static public function updateClanPlayersTanks($clan)
	{
		$url=strtr(self::$wotApiPlayerTanks, array(
				'{applicationId}'=>self::getApplicationId(),
				'{playerId}'=>implode(',', array_keys($clan->players))
		));
		$jsonString= self::getContent($url);
		if($jsonString!=false){
			$jsonData=json_decode($jsonString,true);
			if($jsonData['status']=='ok'){
				$tran=Yii::app()->db->beginTransaction();
				foreach ($jsonData['data'] as $playerId=>$data){
					
				}
				$tran->commit();
			}
		}
	}
	
	/**
	 * 
	 * @param WotClan $clan
	 */
	static public function updateClanProvinces($clan)
	{
		$clanId=$clan->clan_id.'-'.$clan->clan_name;
		$data=self::ajaxRequest("http://worldoftanks.ru/community/clans/$clanId/provinces/list/");
		$currentProvinces=array();
		if(!empty($data)){
			if($data['status']=='ok'){
				foreach ($data['request_data']['items'] as $item){
					$province=WotProvince::getByAttributes($item['name'], $item['id']);
					$map=WotMap::getByName($item['arena_name']);
					$currentProvinces[$item['name']]=$item['id'];
					$clanProvince=WotClanProvince::model()->findByAttributes(array(
						'province_id'=>$province->province_id,
						'clan_id'=>$clan->clan_id,
						'date_end'=>null,
					));
					if(empty($clanProvince)){
						$clanProvince=new WotClanProvince();
						$clanProvince->clan_id=$clan->clan_id;
						$clanProvince->province_id=$province->province_id;
						$clanProvince->prime_time=$item['prime_time'];
						$clanProvince->map_id=$map->map_id;
						$clanProvince->revenue=$item['revenue'];
						$clanProvince->type=$item['type'];
						$days=intval($item['occupancy_time']);
						if($days>0)
							$clanProvince->date_start=new CDbExpression("date_add(curdate(), interval -$days DAY)");
						else
							$clanProvince->date_start=new CDbExpression('curdate()');
						$clanProvince->save(false);
					}
				}
				foreach ($clan->clanProvinces as $clanProvince){
					if(!isset($currentProvinces[$clanProvince->province->province_name])){
						$clanProvince->date_end=new CDbExpression('now()');
						$clanProvince->save(false);
					}
				}
			}
		}
	}
	
	/**
	 * 
	 * @param WotPlayer $player
	 */
	static public function updatePlayerGlory($player)
	{
		$result=self::ajaxRequest("http://worldoftanks.ru/community/clans/show_clan_block/?spa_id={$player->player_id}");
		if(!empty($result)){
			if($result['status']=='ok'){
				$data=$result['data'];
				if(isset($data['glory_points_block'])){
					$block=$data['glory_points_block'];
					$glory=$player->getGlory();
					if(preg_match('/id="js-glory-points".*?>(.*?)<\/a>/', $block,$matches)){
						 $glory->glory_position=preg_replace('/\D/', '', $matches[1])."\n";
					}
					if(preg_match('/Очки славы: (.*?)</', $block,$matches)){
						$glory->glory_points=preg_replace('/\D/', '', $matches[1]);
					}
					$glory->save(false);
				}
			}
		}
	}
	
}