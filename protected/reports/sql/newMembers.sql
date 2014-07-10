SELECT
  wp.player_id,
  wp.player_name,
  wpc.entry_date,
  wcr.clan_role_name,
  DATEDIFF(NOW(), wpc.entry_date) days
FROM wot_player_clan wpc
  JOIN wot_player wp ON wp.player_id = wpc.player_id
  JOIN wot_clan_role wcr ON wcr.clan_role_id = wpc.clan_role_id
WHERE clan_id = :clan
AND wpc.escape_date IS NULL
AND wpc.entry_date > DATE_ADD(NOW(), INTERVAL -1 WEEK)
ORDER BY wpc.entry_date DESC