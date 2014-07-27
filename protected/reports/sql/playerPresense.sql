SELECT
  wp.player_id,
  wp.player_name,
  strength.strength,
  a.updated_at AS dte,
  b.dts,
  a.ab,
  a.gb
FROM wot_player wp
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN (SELECT 
  wp.player_id,
  b.fp*POWER(a.skef, 3)*POWER(wps.frags/wps.battles,2)*(CASE WHEN wps.battles>1000 THEN wps.hits_percents ELSE 0 END) strength

  FROM wot_player wp
  JOIN 
(SELECT 
  wpt.player_id,
  SUM(wpt.wins*(CASE WHEN wpt.battles>300 THEN 300/wpt.battles ELSE 1 END)/
  (CASE WHEN wpt.battles>300 THEN wpt.battles ELSE 300 END)*wt.ivanner_kef)/a.skef AS skef
  FROM wot_player_tank wpt
  JOIN wot_player_clan wpc ON wpt.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_tank wt ON wpt.tank_id = wt.tank_id
  JOIN (SELECT SUM(wt.ivanner_kef) skef FROM wot_tank wt) a
  WHERE wt.tank_level=10 AND wpt.battles>10
  GROUP BY wpt.player_id) a ON a.player_id=wp.player_id
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id=1
  JOIN (SELECT wpt.player_id, SUM(wt.ivanner_kef) fp 
    FROM wot_player_tank wpt
    JOIN wot_tank wt ON wpt.tank_id = wt.tank_id
    WHERE wt.tank_level=10
    GROUP BY wpt.player_id) b ON b.player_id=wp.player_id) strength ON strength.player_id=wp.player_id
  LEFT JOIN 
    (SELECT 
       a.player_id, 
      a.updated_at, 
      COUNT(a.stat_all) ab, 
      COUNT(a.stat_gk) gb 
     FROM (SELECT
            wpsh.player_id,
            wpsh.statistic_id,
            wpsh.updated_at,
            CASE WHEN wpsh.statistic_id = 1 THEN 1 ELSE NULL END stat_all,
            CASE WHEN wpsh.statistic_id = 2 THEN 1 ELSE NULL END stat_gk
          FROM wot_player_statistic_history wpsh
          WHERE wpsh.updated_at > CURDATE() - INTERVAL 30 DAY) a 
    GROUP BY a.player_id, a.updated_at) a ON a.player_id=wp.player_id
   LEFT JOIN 
      (SELECT
        wt.player_id,
        DATE(wp.updated_at) dts
      FROM wot_teamspeak wt
      JOIN wot_presense wp ON wp.client_database_id=wt.client_database_id
      WHERE TIME(wp.updated_at) BETWEEN TIME('20:00') AND TIME('24:00')
      GROUP BY wt.player_id, DATE(wp.updated_at)) b ON a.player_id = b.player_id AND a.updated_at = b.dts