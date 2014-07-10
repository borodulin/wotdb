SELECT
  wp.player_id,
  wp.player_name,
  wps.battles - wpsh.battles battles_count,
  wph.updated_at,
  wp.effect,
  wp.effect - wph.effect heffect,
  wp.wn8,
  wp.wn8 - wph.wn8 hwn8,
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