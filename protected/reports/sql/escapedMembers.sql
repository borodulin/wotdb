SELECT
  wp.player_id,
  wp.player_name,
  wpc.escape_date,
  DATEDIFF(wpc.escape_date, wpc.entry_date) days
FROM wot_player_clan wpc
  JOIN wot_player wp ON wp.player_id = wpc.player_id
WHERE clan_id = :clan AND wpc.escape_date > DATE_ADD(NOW(), INTERVAL -1 WEEK)
ORDER BY wpc.escape_date DESC, days DESC