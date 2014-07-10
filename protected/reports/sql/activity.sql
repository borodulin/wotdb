SELECT 
  wp.player_id,
  wp.player_name,
  wt.tank_name_i18n AS tank_localized_name,
  a.battles-a.pbattles b, 
  a.battles,
  a.pbattles hbattle_count,
  a.wins,
  a.pwins hwin_count,
  a.wins - a.pwins dwins,
  (a.wins - a.pwins) / (a.battles - a.pbattles) * 100 dwin_count,
  a.wins / a.battles * 100 wp,
  a.wins / a.battles * 100 - a.pwins / a.pbattles * 100 dwp
  FROM 
(SELECT 
  wpt.player_id, 
  wpt.tank_id,
  wpt.wins,
  wpt.battles,
  wpth.wins pwins,
  wpth.battles pbattles
  FROM wot_player_tank wpt
  JOIN wot_player_tank_history wpth ON wpt.player_id = wpth.player_id AND wpt.tank_id = wpth.tank_id AND wpth.updated_at=(CURDATE()-INTERVAL 1 DAY )
  JOIN wot_player_clan wpc ON wpt.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan) a
  JOIN wot_player wp ON wp.player_id = a.player_id
  JOIN wot_tank wt ON wt.tank_id=a.tank_id