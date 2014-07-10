SELECT
  wp.player_name,
  wcr.clan_role_name,
  wcr1.clan_role_name old_role,
  wpch.updated_at
FROM wot_player wp
  JOIN wot_player_clan wpc ON wp.player_id = wpc.player_id AND wpc.clan_id=:clan AND wpc.escape_date IS NULL
  JOIN wot_player_clan_history wpch ON wpc.entry_date = wpch.entry_date AND wpc.player_id = wpch.player_id AND wpc.clan_id = wpch.clan_id AND wpch.updated_at > DATE_ADD(CURDATE(), INTERVAL -1 WEEK)
  JOIN wot_clan_role wcr ON wpc.clan_role_id = wcr.clan_role_id
  JOIN wot_clan_role wcr1 ON wpch.clan_role_id = wcr1.clan_role_id
  ORDER by wpch.updated_at DESC 
