SELECT
  wph.player_id,
  UNIX_TIMESTAMP(wph.updated_at) dd,
  wph.effect,
  wph.wn6,
  wph.wn8,
  wpsh.wins / wpsh.battles * 100 wp
FROM wot_player_history wph
  JOIN wot_player_statistic_history wpsh ON wpsh.player_id = wph.player_id AND wpsh.statistic_id = :stat AND wph.updated_at = wpsh.updated_at
WHERE wph.player_id = :player AND wph.effect > 0 AND wph.updated_at < CURDATE() AND wph.updated_at > DATE_ADD(CURDATE(), INTERVAL -3 MONTH)
