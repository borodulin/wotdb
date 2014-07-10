SELECT
  wp.player_name,
  wt.tank_name_i18n AS tank_localized_name,
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