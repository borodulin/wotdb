SELECT
  wp.player_id,
  wp.player_name,
  a.usefulness,
  a.pp,
  a.tops
  FROM wot_player wp
  JOIN 
(SELECT 
  wpt.player_id,
  AVG(CASE WHEN wpt.battles>300 THEN 300 ELSE wpt.battles END) usefulness,
  COUNT(wpt.tank_id) tops,
  SUM(wpt.wins)/SUM(wpt.battles)*100 pp
  FROM wot_player_tank wpt
  JOIN wot_player_clan wpc ON wpt.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_tank wt ON wpt.tank_id = wt.tank_id
  WHERE wt.tank_level=10 AND wpt.battles>10
  GROUP BY wpt.player_id) a ON a.player_id=wp.player_id
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id=1