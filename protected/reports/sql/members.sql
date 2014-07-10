SELECT
  wp.player_name,
  wp.player_id,
  wpc.entry_date,
  wp.created_at,
  DATEDIFF(NOW(), wpc.entry_date) dcnt,
  wcr.clan_role_name,
  wp.updated_at,
  DATEDIFF(NOW(), wp.last_battle_time) inactivity
FROM wot_player_clan wpc
  JOIN wot_player wp ON wp.player_id = wpc.player_id
  JOIN wot_clan_role wcr ON wcr.clan_role_id = wpc.clan_role_id
WHERE wpc.clan_id = :clan AND wpc.escape_date IS NULL