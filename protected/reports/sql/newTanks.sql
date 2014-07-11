SELECT
  wp.player_id,
  wp.player_name,
  wt.tank_name_i18n tank_localized_name,
  wt.tank_image,
  wt.tank_level,
  wpt.battles
FROM wot_player_tank wpt
  JOIN wot_player wp ON wpt.player_id = wp.player_id
  JOIN wot_player_clan wpc ON wp.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_tank wt ON wpt.tank_id = wt.tank_id
WHERE wpt.created_at >= CURDATE() - INTERVAL 2 DAY AND wp.created_at < CURDATE()-INTERVAL 2 DAY
ORDER BY wpt.created_at DESC