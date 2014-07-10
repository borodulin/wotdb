SELECT
  wp.player_name,
  wps.battles,
  wp.created_at,
  wps.battle_avg_xp,
  wps.losses,
  wps.wins,
  wps.wins / wps.battles * 100 AS wp,
  wp.max_xp,
  DATEDIFF(NOW(), wp.last_battle_time) updated_at,
  wps.player_id,
  wp.effect,
  wp.wn6,
  wp.wn7,
  wp.wn8,
  wps.damage_dealt / wps.battles damage
FROM wot_player wp
  JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 1
  JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
ORDER BY wp.player_name