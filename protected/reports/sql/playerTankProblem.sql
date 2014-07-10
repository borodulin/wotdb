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
  (SELECT wpth.wins FROM wot_player_tank_history wpth WHERE wpth.player_id=wpt.player_id AND wpth.tank_id=wpt.tank_id AND wpth.updated_at<DATE(wpt.updated_at)  ORDER BY wpth.updated_at DESC LIMIT 1) pwins
  ,(SELECT wpth.battles FROM wot_player_tank_history wpth WHERE wpth.player_id=wpt.player_id AND wpth.tank_id=wpt.tank_id AND wpth.updated_at<DATE(wpt.updated_at)  ORDER BY wpth.updated_at DESC LIMIT 1) pbattles
  FROM wot_player_tank wpt
  JOIN wot_player_clan wpc ON wpt.player_id = wpc.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
  JOIN wot_tank wt ON wpt.tank_id = wt.tank_id AND wt.tank_level=10 AND wpt.wins/wpt.battles*100<50) a
  JOIN wot_player wp ON wp.player_id = a.player_id
  JOIN wot_tank wt ON wt.tank_id=a.tank_id
