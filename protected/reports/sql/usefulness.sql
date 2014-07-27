SELECT
  wp.player_id,
  wp.player_name,
  a.usefulness,
  a.pp,
  a.tops,
  b.fp*POWER(a.skef, 3)*POWER(wps.frags/wps.battles,2)*(CASE WHEN wps.battles>1000 THEN wps.hits_percents ELSE 0 END) strength
  FROM wot_player wp
  JOIN 
(SELECT 
  wpt.player_id,
  SUM(wpt.wins*(CASE WHEN wpt.battles>300 THEN 300/wpt.battles ELSE 1 END)/
  (CASE WHEN wpt.battles>300 THEN wpt.battles ELSE 300 END)*wt.ivanner_kef)/a.skef AS skef,
  AVG(CASE WHEN wpt.battles>300 THEN 300 ELSE wpt.battles END) usefulness,
  COUNT(wpt.tank_id) tops,
  SUM(wpt.wins)/SUM(wpt.battles)*100 pp
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
    GROUP BY wpt.player_id) b ON b.player_id=wp.player_id