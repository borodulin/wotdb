SELECT
  wp.player_id,
  wp.player_name,
  wa.achievment_name,
  IFNULL(wav.name,wa.name) name,
  wa.description,
  wa.section,
  s.max_cnt
FROM wot_player_achievment wpa
  JOIN wot_player wp ON wpa.player_id = wp.player_id
  JOIN wot_player_clan wpc ON wp.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_achievment wa ON wpa.achievment_id = wa.achievment_id
  
  JOIN (SELECT
      a.achievment_id,
      MAX(max_cnt) max_cnt,
      MIN(min_cnt) min_cnt
    FROM wot_player_achievment wpa
   JOIN wot_achievment wa ON wpa.achievment_id = wa.achievment_id
      JOIN (SELECT
          wpa.achievment_id,
          MAX(wpa.cnt) max_cnt,
          MIN(wpa.cnt) min_cnt
        FROM wot_player_achievment wpa
          JOIN wot_player_clan wpc
            ON wpa.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
        GROUP BY wpa.achievment_id) a
        ON a.achievment_id = wpa.achievment_id AND ((a.max_cnt = wpa.cnt AND wa.type<>'class')OR(a.min_cnt = wpa.cnt AND wa.type='class'))
    GROUP BY a.achievment_id
    HAVING COUNT(*) = 1) s ON s.achievment_id = wpa.achievment_id AND ((s.max_cnt = wpa.cnt AND wa.type<>'class')OR(s.min_cnt = wpa.cnt AND wa.type='class'))
  LEFT JOIN wot_achievment_variant wav ON wa.achievment_id = wav.achievment_id AND wav.variant_id=s.max_cnt
  WHERE wa.name IS NOT NULL
ORDER BY wp.player_name