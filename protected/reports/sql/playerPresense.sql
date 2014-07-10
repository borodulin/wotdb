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
  JOIN wot_clan_role wcr  ON wpc.clan_role_id = wcr.clan_role_id
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