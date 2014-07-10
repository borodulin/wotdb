wotdb
=====

System requirements.
  1. MySQL 5.5 or greater with INNODB engine enabled
  2. php 5.4 ()
  3. Apache 2.2 (or Nginx + PHP-FPM)


Install instructions.

  1. Download the latest version or get it from repositiory by SVN CO
  2. Download the latest version of Yii framework and put it into "protected" folder.
  3. Create folders "assets" and "protected/runtime" with write permissions
  4. Get application_id from https://ru.wargaming.net/developers
  5. Rename and modify "protected/config/sample_db.php". If you have enabled SMTP server, you can use "mairoute.php" to configure Email reporting (errors raised from console commands).
  6. Create database using  "protected/data/schema.sql" and "protected/data/wot_wn8_etv.sql"
  7. If you have Teamspeak server, you can integrate it with by specifying "tsUri" param in protected/config/db.php
  8. Configure cron jobs: 
  
  9.1. Scan action performs main working set

    sample cron config:  0 */2 * * * /..../wotdb/protected/yiic cron scan

  9.2. ScanStat action calculate current clan statistics values, triggers history
  
    sample cron config:  0 */6 * * * /..../wotdb/protected/yiic cron clanStat

  9.3. Presense action makes integration with Teamspeak server, looks clan members activity (cron schedule may depends of the Clan Prime-Time)
  
    sample cron config:  */15 19-23 * * * /..../wotdb/protected/yiic cron presense

  9.4. Ivanner action parse current values from Ivanner resource
  
    sample cron config:  0 */6 * * * /..../wotdb/protected/yiic cron ivanner

  9.5. Armor action parse current values from armor.kiev.ua/wot/ resource
  
    sample cron config:  0 */6 * * * /..../wotdb/protected/yiic cron armor
