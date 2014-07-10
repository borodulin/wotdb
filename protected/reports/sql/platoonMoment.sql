SELECT
    wp.player_id,
    wp.player_name,
    wps.battles,
    wps.wins / wps.battles * 100 AS wp,
    SIGN(wps.wins / wps.battles -0.5)* SQRT(wps.battles*power((wps.wins / wps.battles -0.5) * 100,2)/2) AS moment
FROM wot_player wp
    JOIN wot_player_clan wpc ON wpc.player_id = wp.player_id AND wpc.escape_date IS NULL AND wpc.clan_id = :clan
    JOIN wot_player_statistic wps ON wp.player_id = wps.player_id AND wps.statistic_id = 3
ORDER BY moment DESC