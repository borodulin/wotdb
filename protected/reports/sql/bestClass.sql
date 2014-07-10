SELECT wp.player_name, SUM(wpt.win_count)/SUM(wpt.battle_count)*100,SUM(wpt.damageDealt)/SUM(wpt.battle_count),SUM(wpt.battle_count),
  ((185/(0.17+ EXP((SUM(wpt.win_count)/SUM(wpt.battle_count)*100-35)*-0.134)))-500)*0.45+
  667*SUM(wpt.frags)/SUM(wpt.battle_count)+
  SUM(wpt.damageDealt)/SUM(wpt.battle_count)*0.24+
  SUM(wpt.spotted)/SUM(wpt.battle_count)*125 eff,
  ((185/(0.17+ EXP((SUM(wpt.win_count)/SUM(wpt.battle_count)*100-35)*-0.134)))-500)*0.45 a,
  667*SUM(wpt.frags)/SUM(wpt.battle_count) b,
  SUM(wpt.damageDealt)/SUM(wpt.battle_count)*0.24 c,
  SUM(wpt.spotted)/SUM(wpt.battle_count)*125 d
--  CASE case_operand
--    WHEN wpt.damageDealt/wpt.battle_count>wp.damage_dealt/wp.battles_count THEN 1+(wpt.damageDealt/wpt.battle_count-wp.damage_dealt/wp.battles_count)/(wp.)
--    ELSE
--  END

  FROM wot_player_tank wpt
  JOIN wot_player_clan wpc ON wpc.player_id=wpt.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
  JOIN wot_tank wt ON wt.tank_id=wpt.tank_id
  JOIN wot_player wp ON wp.player_id=wpt.player_id
  WHERE wt.tank_level=8 AND wt.tank_class_id='SPG'
  GROUP BY wp.player_name