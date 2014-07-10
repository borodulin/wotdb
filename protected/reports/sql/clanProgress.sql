SELECT DATE_FORMAT(wph.updated_at,'%Y%m%d'), avg(wph.effect), avg(wph.wn6), MAX(wph.wins/wph.battles_count*100), a.wp, a.a6, a.ae, a.pc,
  (a.ae*a.pc-wp.effect+wph.effect)/a.pc deffect,
  (a.a6*a.pc-wp.wn6+wph.wn6)/a.pc dwn6,
  (a.wp*a.pc-wp.wins/wp.battles_count*100+wph.wins/wph.battles_count*100)/a.pc dwp
  FROM wot_player_history wph
  JOIN wot_player_clan wpc ON wpc.player_id=wph.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan
  JOIN wot_player wp ON wp.player_id=wph.player_id
  JOIN (SELECT AVG(wp.effect) ae, AVG(wp.wn6) a6, AVG(wp.wins/wp.battles_count)*100 wp, COUNT(1) pc
          FROM wot_player wp JOIN wot_player_clan wpc ON wpc.player_id=wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id=:clan ) a
  WHERE wph.effect>0
  GROUP BY  DATE_FORMAT(wph.updated_at,'%Y%m%d')