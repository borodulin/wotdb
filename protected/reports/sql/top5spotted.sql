SELECT
  wp.player_name,
  ROUND(wps.spotted / wps.battles, 2) AS spotted
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 1
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY spotted DESC
LIMIT 5