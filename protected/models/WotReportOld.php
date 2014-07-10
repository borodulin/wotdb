<?php

class WotReportOld
{
	public static function report()
	{
		$sql=<<<SQL
SELECT
  wpt.battles - wpth.battles b,
  wp.player_name,
  wt.tank_localized_name,
  wpt.updated_at,
  wpth.updated_at hupdated_at,
  wpt.battles,
  wpth.battles hbattle_count,
  wpt.wins,
  wpth.wins hwin_count,
  wpt.wins - wpth.wins dwins,
  (wpt.wins - wpth.wins) / (wpt.battles - wpth.battles) * 100 dwin_count,
  wpt.wins / wpt.battles * 100 wp,
  wpt.wins / wpt.battles * 100 - wpth.wins / wpth.battles * 100 dwp
FROM wot_player_tank wpt
  JOIN wot_player wp ON wp.player_id = wpt.player_id
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_tank wt ON wt.tank_id = wpt.tank_id
  JOIN (SELECT
    pt.player_id,
    pt.tank_id,
    (SELECT
      MIN(pth.updated_at)
    FROM wot_player_tank_history pth
    WHERE pth.updated_at > DATE_ADD(pt.updated_at, INTERVAL -2 DAY)
    AND pth.player_id = pt.player_id
    AND pth.tank_id = pt.tank_id) last_updated_at
  FROM wot_player_tank pt) a ON a.player_id = wpt.player_id AND a.tank_id = wpt.tank_id
  JOIN wot_player_tank_history wpth ON wpth.player_id = a.player_id AND wpth.tank_id = a.tank_id AND wpth.updated_at = a.last_updated_at
WHERE wpt.updated_at > DATE_ADD(NOW(), INTERVAL -1 WEEK)
ORDER BY wpt.player_id, wpt.battles - wpth.battles DESC
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function players()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  wps.battles,
  wp.created_at,
  wps.battle_avg_xp,
  wps.losses,
  wps.wins,
  wps.wins / wps.battles * 100 AS wp,
  wp.max_xp,
  DATEDIFF(NOW(), wp.updated_at) updated_at,
  wps.player_id,
  wp.effect,
  wp.wn6,
  wps.damage_dealt / wps.battles damage
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 1
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY wp.player_name
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}


	public static function medals()
	{
		$sql=<<<SQL
SELECT
  p.player_name,
  p.achievements
FROM
  wot_player p
  join wot_player_clan pc on pc.player_id=p.player_id and pc.escape_date is null and pc.clan_id=:clan
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		$result=array();
		foreach ($data as $row) {
			$res=unserialize($row['achievements']);
			$res['player_name']=$row['player_name'];
			$result[]=$res;
		}
		return $result;
	}

	public static function tanks()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  wt.tank_localized_name,
  wpt.battles,
  wpt.wins,
  wpt.wins / wpt.battles * 100 AS wp,
  s.cnt
FROM wot_player wp
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_player_tank wpt ON wpt.player_id = wp.player_id
  JOIN wot_tank wt ON wt.tank_id = wpt.tank_id AND wt.tank_level = 10
JOIN (SELECT wpt.player_id, COUNT(1) cnt  FROM wot_player_tank wpt 
        JOIN wot_tank wt ON wpt.tank_id = wt.tank_id AND wt.tank_level=10
        GROUP BY wpt.player_id) s
  ON s.player_id = wpt.player_id
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function members()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  wp.player_id,
  wpc.entry_date,
  wp.created_at,
  DATEDIFF(NOW(), wpc.entry_date) dcnt,
  wcr.clan_role_name,
  wp.updated_at
FROM wot_player_clan wpc
  JOIN wot_player wp ON wp.player_id = wpc.player_id
  JOIN wot_clan_role wcr ON wcr.clan_role_id = wpc.clan_role_id
WHERE wpc.clan_id = :clan AND wpc.escape_date IS NULL
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}


	public static function newMembers()
	{
		$sql=<<<SQL
SELECT
  wp.player_id,
  wp.player_name,
  wpc.entry_date,
  wcr.clan_role_name,
  DATEDIFF(NOW(), wpc.entry_date) days
FROM wot_player_clan wpc
  JOIN wot_player wp ON wp.player_id = wpc.player_id
  JOIN wot_clan_role wcr ON wcr.clan_role_id = wpc.clan_role_id
WHERE clan_id = :clan
AND wpc.escape_date IS NULL
AND wpc.entry_date > DATE_ADD(NOW(), INTERVAL -1 WEEK)
ORDER BY wpc.entry_date DESC
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}


	public static function escapedMembers()
	{
		$sql=<<<SQL
SELECT
  wp.player_id,
  wp.player_name,
  wpc.escape_date,
  DATEDIFF(wpc.escape_date, wpc.entry_date) days
FROM wot_player_clan wpc
  JOIN wot_player wp ON wp.player_id = wpc.player_id
WHERE clan_id = :clan AND wpc.escape_date > DATE_ADD(NOW(), INTERVAL -1 WEEK)
ORDER BY wpc.escape_date DESC, days DESC
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function career()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  wcr.clan_role_name,
  wcr1.clan_role_name new_role,
  wpch.clan_history_date
FROM wot_player_clan_history wpch
  JOIN wot_clan_role wcr ON wcr.clan_role_id = wpch.clan_role_id
  JOIN wot_player wp ON wp.player_id = wpch.player_id
  JOIN wot_player_clan wpc ON wpc.clan_id = wpch.clan_id AND wpc.player_id = wp.player_id
  JOIN wot_clan_role wcr1 ON wcr1.clan_role_id = wpc.clan_role_id
WHERE wpch.clan_history_date > DATE_ADD(CURDATE(), INTERVAL -1 WEEK) AND wpch.clan_id = :clan
ORDER BY wpch.clan_history_date DESC
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function top5effect()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  wp.effect
FROM wot_player wp
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY wp.effect DESC
LIMIT 5
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function top5damage()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  ROUND(wps.damage_dealt / wps.battles, 2) AS dmg
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 1
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY dmg DESC
LIMIT 5
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function top5spotted()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  ROUND(wps.spotted / wps.battles, 2) AS spotted
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 1
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY spotted DESC
LIMIT 5
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function top5capture()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  ROUND(wps.capture_points / wps.battles, 2) AS capture
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id=1
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY capture DESC
LIMIT 5
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function top5defense()
	{
		$sql=<<<SQL
SELECT
  wp.player_name,
  ROUND(wps.dropped_capture_points / wps.battles, 2) AS defense
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 1
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY defense DESC
LIMIT 5
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function newTanks()
	{
		$sql=<<<SQL
SELECT
  wp.player_id,
  wp.player_name,
  wt.tank_localized_name,
  wt.tank_image,
  wt.tank_level
FROM wot_player_tank wpt
  JOIN wot_player wp ON wpt.player_id = wp.player_id
  JOIN wot_player_clan wpc ON wp.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_tank wt ON wpt.tank_id = wt.tank_id
WHERE wpt.created_at > DATE_ADD(NOW(), INTERVAL -2 DAY) AND wp.created_at < DATE_ADD(NOW(), INTERVAL -3 DAY)
ORDER BY wpt.created_at DESC
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function bestClass($class)
	{
		$sql=<<<SQL
SELECT wp.player_name, SUM(wpt.win_count)/SUM(wpt.battle_count)*100,SUM(wpt.damageDealt)/SUM(wpt.battle_count),SUM(wpt.battle_count),
  ((185/(0.17+ EXP((SUM(wpt.win_count)/SUM(wpt.battle_count)*100-35)*-0.134)))-500)*0.45+
  667*SUM(wpt.frags)/SUM(wpt.battle_count)+
  SUM(wpt.damageDealt)/SUM(wpt.battle_count)*0.24+
  SUM(wpt.spotted)/SUM(wpt.battle_count)*125 eff,
  ((185/(0.17+ EXP((SUM(wpt.win_count)/SUM(wpt.battle_count)*100-35)*-0.134)))-500)*0.45 a,
  667*SUM(wpt.frags)/SUM(wpt.battle_count) b,
  SUM(wpt.damageDealt)/SUM(wpt.battle_count)*0.24 c,
  SUM(wpt.spotted)/SUM(wpt.battle_count)*125 d
--  CASE case_operand
--    WHEN wpt.damageDealt/wpt.battle_count>wp.damage_dealt/wp.battles_count THEN 1+(wpt.damageDealt/wpt.battle_count-wp.damage_dealt/wp.battles_count)/(wp.)
--    ELSE
--  END

  FROM wot_player_tank wpt
  JOIN wot_player_clan wpc ON wpc.player_id=wpt.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
  JOIN wot_tank wt ON wt.tank_id=wpt.tank_id
  JOIN wot_player wp ON wp.player_id=wpt.player_id
  WHERE wt.tank_level=8 AND wt.tank_class_id='SPG'
  GROUP BY wp.player_name
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function progress()
	{
		$sql=<<<SQL
SELECT
  wp.player_id,
  wp.player_name,
  wps.battles - wpsh.battles battles_count,
  wph.updated_at,
  wp.effect,
  wp.effect - wph.effect heffect,
  wp.wn6,
  wp.wn6 - wph.wn6 hwn6,
  wps.wins / wps.battles * 100 winp,
  wps.wins / wps.battles * 100 - wpsh.wins / wpsh.battles * 100 hwinp,
  wps.capture_points / wps.battles cp,
  wps.capture_points / wps.battles - wpsh.capture_points / wpsh.battles hcp,
  wps.spotted / wps.battles spotted,
  wps.spotted / wps.battles - wpsh.spotted / wpsh.battles hspotted,
  wps.hits_percents hitp,
  wps.hits_percents - wpsh.hits_percents hhitp,
  wps.dropped_capture_points / wps.battles dcp,
  wps.dropped_capture_points / wps.battles - wpsh.dropped_capture_points / wpsh.battles hdcp,
  wps.survived_battles / wps.battles sb,
  wps.survived_battles / wps.battles - wpsh.survived_battles / wpsh.battles hsb,
  wps.damage_dealt / wps.battles damage,
  wps.damage_dealt / wps.battles - wpsh.damage_dealt / wpsh.battles hdamage,
  wps.battle_avg_xp,
  wps.battle_avg_xp - wpsh.battle_avg_xp hbattle_avg_xp,
  wps.frags / wps.battles frags,
  wps.frags / wps.battles - wpsh.frags / wpsh.battles hfrags,
  wp.max_xp,
  wp.max_xp - wph.max_xp hmax_xp
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 1
  JOIN (SELECT
    MIN(wpsh.updated_at) updated_at,
    wpsh.player_id,
    wpsh.statistic_id
  FROM wot_player_statistic_history wpsh
    JOIN wot_player_clan wpc
      ON wpsh.player_id = wpc.player_id AND wpc.clan_id = :clan AND wpc.escape_date IS NULL
  WHERE wpsh.updated_at > DATE_ADD(NOW(), INTERVAL -2 DAY)
  GROUP BY wpsh.player_id,
           wpsh.statistic_id) a ON a.player_id = wp.player_id AND a.statistic_id = wps.statistic_id
  JOIN wot_player_statistic_history wpsh ON wpsh.updated_at = a.updated_at AND wpsh.player_id = a.player_id AND wpsh.statistic_id = a.statistic_id
  JOIN (SELECT
    MIN(wph.updated_at) updated_at,
    wph.player_id
  FROM wot_player_history wph
    JOIN wot_player_clan wpc
      ON wpc.player_id = wph.player_id AND wpc.clan_id = :clan AND wpc.escape_date IS NULL
  WHERE wph.updated_at > DATE_ADD(NOW(), INTERVAL -2 DAY)
  GROUP BY wph.player_id) s ON s.player_id = wp.player_id
  JOIN wot_player_history wph ON wph.updated_at = s.updated_at AND wph.player_id = s.player_id
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function clanProgress()
	{
		$sql=<<<SQL
SELECT DATE_FORMAT(wph.updated_at,'%Y%m%d'), avg(wph.effect), avg(wph.wn6), MAX(wph.wins/wph.battles_count*100), a.wp, a.a6, a.ae, a.pc,
  (a.ae*a.pc-wp.effect+wph.effect)/a.pc deffect,
  (a.a6*a.pc-wp.wn6+wph.wn6)/a.pc dwn6,
  (a.wp*a.pc-wp.wins/wp.battles_count*100+wph.wins/wph.battles_count*100)/a.pc dwp
  FROM wot_player_history wph
  JOIN wot_player_clan wpc ON wpc.player_id=wph.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
  JOIN wot_player wp ON wp.player_id=wph.player_id
  JOIN (SELECT AVG(wp.effect) ae, AVG(wp.wn6) a6, AVG(wp.wins/wp.battles_count)*100 wp, COUNT(1) pc
          FROM wot_player wp JOIN wot_player_clan wpc ON wpc.player_id=wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan ) a
  WHERE wph.effect>0
  GROUP BY  DATE_FORMAT(wph.updated_at,'%Y%m%d')
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}

	public static function playerProgress($playerId)
	{
		$sql=<<<SQL
SELECT
  wph.player_id,
  UNIX_TIMESTAMP(DATE(wph.updated_at)) dd,
  MAX(wph.effect) effect,
  MAX(wph.wn6) wn6,
  MAX(wpsh.wins / wpsh.battles * 100) wp
FROM wot_player_history wph
  JOIN wot_player_statistic_history wpsh ON wpsh.player_id = wph.player_id AND wpsh.statistic_id = :stat
WHERE wph.player_id = :player AND wph.effect > 0 AND DATE(wph.updated_at) < CURDATE() AND DATE(wph.updated_at) > DATE_ADD(CURDATE(), INTERVAL -3 MONTH)
GROUP BY DATE(wph.updated_at),
         wph.player_id
UNION (SELECT
  wp.player_id,
  UNIX_TIMESTAMP(DATE(wp.updated_at)),
  wp.effect,
  wp.wn6,
  wps.wins / wps.battles * 100
FROM wot_player wp
JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id=:stat
WHERE wp.player_id = :player
ORDER BY wp.updated_at DESC LIMIT 1)
ORDER BY dd
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('player'=>$playerId, 'stat'=>1));
		return $data;
	}

	public static function playerPresense()
	{
		$sql=<<<SQL
SELECT
  wp.player_id,
  wp.player_name,
  wcr.clan_role_name,
  a.updated_at AS dte,
  b.dts,
  a.ab,
  a.gb
FROM wot_player wp
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_clan_role wcr ON wpc.clan_role_id = wcr.clan_role_id
  LEFT JOIN (SELECT
    a.player_id,
    a.updated_at,
    COUNT(a.b_all) ab,
    COUNT(a.b_gk) gb,
    COUNT(a.b_cm)
  FROM (SELECT
    s.player_id,
    s.statistic_id,
    DATE(s.updated_at) updated_at,
    MIN(s.battles),
    CASE s.statistic_id
      WHEN 1 THEN 1 ELSE NULL
    END b_all,
    CASE s.statistic_id
      WHEN 2 THEN 1 ELSE NULL
    END b_gk,
    CASE s.statistic_id
      WHEN 3 THEN 1 ELSE NULL
    END b_cm
  FROM (
  SELECT
    wpsh.player_id,
    wpsh.statistic_id,
    wpsh.updated_at,
    wpsh.battles
  FROM wot_player_statistic_history wpsh) s
  GROUP BY s.player_id,
           s.statistic_id,
           DATE(s.updated_at)) a
  GROUP BY a.player_id,
           a.updated_at) a ON a.player_id = wp.player_id
  LEFT JOIN (SELECT
    wt.player_id,
    DATE(wt.updated_at) dts
  FROM wot_teamspeak wt
  WHERE TIME(wt.updated_at) BETWEEN TIME('20:00') AND TIME('24:00')
  GROUP BY wt.player_id,
           DATE(wt.updated_at)) b ON a.player_id = b.player_id AND a.updated_at = b.dts
SQL;

		$dates=array();
		for ($i = date('t'); $i >0; $i--) {
			$date = date_create('now');
			date_add($date, date_interval_create_from_date_string("-$i days"));
			$dates[]=date_format($date, 'Y-m-d');
		}

		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		$result=array();
		$names=array();

		foreach ($data as $row){
			if(!isset($result[$row['player_id']])){
				$result[$row['player_id']]=array('player_name'=>$row['player_name'],'clan_role_name'=>$row['clan_role_name']);
				foreach ($dates as $date){
					$result[$row['player_id']][$date]=0;
				}
			}
			$pres=0;
			if($row['ab']>0)
			    $pres=1;
			if(!empty($row['dts']))
			    $pres=$pres+2;
			if($row['gb']>0)
			    $pres=$pres+4;
			if($pres>0)    
			    $result[$row['player_id']][$row['dte']]=$pres;
		}
		$res=array();
		foreach ($result as $row){
			$res[]=$row;
		}
		return array('data'=>$res,'dates'=>$dates);
	}

	public static function playerProgressTanks($playerId, $date)
	{
		$sql=<<<SQL
SELECT
  wpth.battle_count-wpth1.battle_count bc,
 -- wpth.damageDealt/wpth.battle_count ddd,
--  wpth1.damageDealt/wpth1.battle_count ddddd,
--  wpth.damageDealt/wpth.battle_count-wpth1.damageDealt/wpth1.battle_count dd,
  wpth.win_count-wpth1.win_count wc,
  (wpth.win_count-wpth1.win_count)/(wpth.battle_count-wpth1.battle_count)*100 pw,
wt.tank_localized_name,
wp.player_name
  FROM wot_player_tank_history wpth
  JOIN (SELECT MAX(pth.updated_at) updated_at, pth.player_id, pth.tank_id
    FROM wot_player_tank_history pth
    WHERE pth.updated_at <  DATE_ADD(DATE(FROM_UNIXTIME(:date)),INTERVAL 1 DAY) AND pth.updated_at>DATE(FROM_UNIXTIME(:date))
    AND pth.player_id = :player_id
          GROUP BY pth.player_id, pth.tank_id
          ) last_updated_at ON last_updated_at.updated_at=wpth.updated_at AND last_updated_at.player_id=wpth.player_id AND last_updated_at.tank_id=wpth.tank_id
JOIN wot_player_tank_history wpth1 ON wpth.tank_id = wpth1.tank_id AND wpth.player_id = wpth1.player_id
JOIN (SELECT MAX(pth.updated_at) updated_at, pth.player_id, pth.tank_id
    FROM wot_player_tank_history pth
    WHERE pth.updated_at <  DATE_ADD(DATE(FROM_UNIXTIME(:date)),INTERVAL -1 DAY)
    AND pth.player_id = :player_id
          GROUP BY pth.player_id, pth.tank_id
          ) pre_updated_at ON pre_updated_at.updated_at=wpth1.updated_at AND pre_updated_at.player_id=wpth1.player_id AND pre_updated_at.tank_id=wpth1.tank_id
  JOIN wot_tank wt ON wt.tank_id=wpth.tank_id
  JOIN wot_player wp ON wp.player_id=wpth.player_id
ORDER BY bc DESC
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('player_id'=>$playerId, 'date'=>$date));
		return $data;
	}
	
	public static function veteranGK()
	{
	    $sql=<<<SQL
SELECT
    wp.player_id,
    wp.player_name,
    wps.battles,
    wps.wins / wps.battles * 100 AS wp
FROM wot_player wp
    JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
    JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 2
ORDER BY wps.battles DESC
SQL;
	    $data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
	    return $data;
	    
	}
	
	public static function platoonMoment()
	{
	    $sql=<<<SQL
SELECT
    wp.player_id,
    wp.player_name,
    wps.battles,
    wps.wins / wps.battles * 100 AS wp,
    SIGN(wps.wins / wps.battles -0.5)* SQRT(wps.battles*power((wps.wins / wps.battles -0.5) * 100,2)/2) AS moment
FROM wot_player wp
    JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
    JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 3
ORDER BY moment DESC
SQL;
	    $data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
	    return $data;
	}
	
	public static function bestAchievments()
	{
		$sql=<<<SQL
SELECT wp.player_id, wp.player_name, wa.achievment_name, wa.name, wa.section, s.max_cnt FROM wot_player_achievment wpa
  JOIN wot_player wp ON wpa.player_id = wp.player_id
  JOIN wot_achievment wa ON wpa.achievment_id = wa.achievment_id
  JOIN 
(SELECT a.achievment_id, MAX(max_cnt) max_cnt FROM  
  wot_player_achievment wpa
  JOIN (
SELECT wpa.achievment_id, MAX(wpa.cnt) max_cnt FROM wot_player_achievment wpa
  GROUP BY wpa.achievment_id) a ON a.achievment_id=wpa.achievment_id AND a.max_cnt=wpa.cnt
  GROUP BY a.achievment_id HAVING COUNT(*)=1) s ON s.achievment_id=wpa.achievment_id AND s.max_cnt=wpa.cnt
  ORDER BY wa.section, wp.player_name
SQL;
		$data=Yii::app()->db->cache(3600)->createCommand($sql)->queryAll(true,array('clan'=>WotClan::$clanId));
		return $data;
	}
	
}
