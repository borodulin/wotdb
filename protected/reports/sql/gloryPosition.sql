SELECT
  a.player_id,
  a.player_name,
  a.days,
  a.clan_role_name,
  a.glory_points,
  a.glory_position,
  a.glory_points - wpg.glory_points AS dglory_points,
  wpg.glory_position - a.glory_position AS dglory_position
FROM (SELECT
  wp.player_id,
  wp.player_name,
  DATEDIFF(CURDATE(), wpc.entry_date) days,
  wcr.clan_role_name,
  wpg.glory_points,
  wpg.glory_position,
  (SELECT
    MAX(wpg1.updated_at)
  FROM wot_player_glory wpg1
  WHERE wpg1.player_id = wp.player_id AND wpg1.updated_at < wpg.updated_at) AS updated_prev
FROM wot_player wp
  JOIN wot_player_clan wpc
    ON wp.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
  JOIN wot_clan_role wcr
    ON wpc.clan_role_id = wcr.clan_role_id
  JOIN (SELECT
    MAX(wpg.updated_at) updated_at
  FROM wot_player_glory wpg) mup
  JOIN wot_player_glory wpg
    ON wp.player_id = wpg.player_id AND wpg.updated_at = mup.updated_at) a
  LEFT JOIN wot_player_glory wpg ON wpg.updated_at = a.updated_prev AND wpg.player_id = a.player_id
  ORDER BY a.days DESC