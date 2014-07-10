-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.1.166.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 10.07.2014 2:10:20
-- Версия сервера: 5.7.4-m14-log
-- Версия клиента: 4.1

USE wotdb;

CREATE TABLE tbl_lookup (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(128) NOT NULL,
  code int(11) NOT NULL,
  type varchar(128) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 6
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8
COLLATE utf8_unicode_ci;

CREATE TABLE tbl_tag (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(128) NOT NULL,
  frequency int(11) DEFAULT 1,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_unicode_ci;

CREATE TABLE tbl_user (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(128) NOT NULL,
  password varchar(128) NOT NULL,
  salt varchar(128) NOT NULL,
  email varchar(128) NOT NULL,
  profile text DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 2
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_unicode_ci;

CREATE TABLE wf_forum (
  forum_id int(11) NOT NULL AUTO_INCREMENT,
  parent_id int(11) NOT NULL,
  caption varchar(255) NOT NULL,
  ftype enum ('category', 'forum') NOT NULL DEFAULT 'forum',
  ctime datetime NOT NULL,
  mtime timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  status enum ('active', 'deleted', 'closed', 'invisible') NOT NULL DEFAULT 'active',
  is_fixed tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (forum_id),
  CONSTRAINT FK_wf_forum_wf_forum_forum_id FOREIGN KEY (parent_id)
  REFERENCES wf_forum (forum_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_achievment (
  achievment_id int(11) NOT NULL AUTO_INCREMENT,
  achievment_name varchar(100) NOT NULL,
  name varchar(100) DEFAULT NULL,
  section enum ('special', 'epic', 'battle', 'group', 'memorial', 'class') DEFAULT NULL,
  type enum ('custom', 'repeatable', 'series', 'class') DEFAULT NULL,
  image varchar(255) DEFAULT NULL,
  description text DEFAULT NULL,
  PRIMARY KEY (achievment_id),
  INDEX IDX_wot_achievment_type (type),
  UNIQUE INDEX UK_wot_achievment_achievment_name (achievment_name)
)
ENGINE = INNODB
AUTO_INCREMENT = 224
AVG_ROW_LENGTH = 833
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_arena (
  arena_id int(11) NOT NULL AUTO_INCREMENT,
  arena_name varchar(50) NOT NULL,
  PRIMARY KEY (arena_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_battle_type (
  type_id int(11) NOT NULL AUTO_INCREMENT,
  type_name varchar(50) NOT NULL,
  type_descr varchar(100) DEFAULT NULL,
  PRIMARY KEY (type_id),
  UNIQUE INDEX UK_wot_battle_type_type_uid (type_name)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_clan (
  clan_id int(11) NOT NULL,
  clan_name varchar(100) NOT NULL,
  updated_at datetime DEFAULT NULL,
  clan_fullname varchar(255) DEFAULT NULL,
  clan_created datetime DEFAULT NULL,
  clan_descr text DEFAULT NULL,
  clan_ico varchar(255) DEFAULT NULL,
  clan_motto text DEFAULT NULL,
  clan_descr_html text DEFAULT NULL,
  clan_owner_id int(11) DEFAULT NULL,
  ivanner_pos int(11) DEFAULT NULL,
  ivanner_strength int(11) DEFAULT NULL,
  ivanner_firepower int(11) DEFAULT NULL,
  ivanner_skill int(11) DEFAULT NULL,
  players_count int(11) DEFAULT NULL,
  players_wn8 decimal(10, 2) DEFAULT NULL,
  players_pp decimal(5, 2) DEFAULT NULL,
  armor_gk_pos int(11) DEFAULT NULL,
  armor_gk_val decimal(10, 2) DEFAULT NULL,
  armor_random_pos int(11) DEFAULT NULL,
  armor_random_val decimal(10, 2) DEFAULT NULL,
  PRIMARY KEY (clan_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_clan_role (
  clan_role_id varchar(50) NOT NULL,
  clan_role_name varchar(50) NOT NULL,
  PRIMARY KEY (clan_role_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 2730
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player (
  player_id int(11) NOT NULL,
  player_name varchar(100) NOT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  player_fio varchar(255) DEFAULT NULL,
  player_bitrh datetime DEFAULT NULL,
  max_xp int(11) NOT NULL DEFAULT 0,
  effect decimal(10, 2) NOT NULL DEFAULT 0.00,
  wn6 decimal(10, 2) NOT NULL DEFAULT 0.00,
  wn7 decimal(10, 2) DEFAULT NULL,
  wn8 decimal(10, 2) DEFAULT NULL,
  global_rating int(11) DEFAULT NULL,
  last_battle_time datetime DEFAULT NULL,
  logout_at datetime DEFAULT NULL,
  PRIMARY KEY (player_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5576
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_statistic (
  statistic_id int(11) NOT NULL AUTO_INCREMENT,
  statistic_name varchar(50) NOT NULL,
  PRIMARY KEY (statistic_id),
  UNIQUE INDEX UK_wot_staistic_statistic_name (statistic_name)
)
ENGINE = INNODB
AUTO_INCREMENT = 5
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_tank_class (
  tank_class_id varchar(50) NOT NULL,
  tank_class_name varchar(20) NOT NULL,
  PRIMARY KEY (tank_class_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_tank_nation (
  tank_nation_id varchar(50) NOT NULL,
  tank_nation_name varchar(50) NOT NULL,
  PRIMARY KEY (tank_nation_id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE tbl_post (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(128) NOT NULL,
  content text NOT NULL,
  tags text DEFAULT NULL,
  status int(11) NOT NULL,
  create_time int(11) DEFAULT NULL,
  update_time int(11) DEFAULT NULL,
  author_id int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_post_author FOREIGN KEY (author_id)
  REFERENCES tbl_user (id) ON DELETE CASCADE ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_unicode_ci;

CREATE TABLE wf_forum_access (
  forum_id int(11) NOT NULL,
  clan_role_id varchar(50) NOT NULL,
  `right` enum ('view', 'create', 'post', 'file') NOT NULL,
  PRIMARY KEY (forum_id, clan_role_id, `right`),
  CONSTRAINT FK_wf_forum_access_wf_forum_forum_id FOREIGN KEY (forum_id)
  REFERENCES wf_forum (forum_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wf_forum_access_wot_clan_role_clan_role_id FOREIGN KEY (clan_role_id)
  REFERENCES wot_clan_role (clan_role_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wf_forum_action (
  forum_id int(11) NOT NULL,
  player_id int(11) NOT NULL,
  action enum ('delete', 'close', 'hide', 'fix') NOT NULL,
  PRIMARY KEY (forum_id, player_id, action),
  CONSTRAINT FK_wf_forum_action_wf_forum_forum_id FOREIGN KEY (forum_id)
  REFERENCES wf_forum (forum_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wf_forum_action_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wf_moderator (
  player_id int(11) NOT NULL,
  forum_id int(11) NOT NULL,
  ctime datetime NOT NULL,
  mtime timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (player_id, forum_id),
  CONSTRAINT FK_wf_moderator_wf_forum_forum_id FOREIGN KEY (forum_id)
  REFERENCES wf_forum (forum_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wf_moderator_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wf_post (
  post_id int(11) NOT NULL AUTO_INCREMENT,
  forum_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  reply_to int(11) DEFAULT NULL,
  caption varchar(255) DEFAULT NULL,
  is_topic tinyint(1) DEFAULT NULL,
  ctime datetime NOT NULL,
  body mediumtext NOT NULL,
  mtime timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  status enum ('active', 'deleted', 'invisible') NOT NULL DEFAULT 'active',
  PRIMARY KEY (post_id),
  UNIQUE INDEX UK_wf_post (forum_id, is_topic),
  CONSTRAINT FK_wf_post_wf_forum_forum_id FOREIGN KEY (forum_id)
  REFERENCES wf_forum (forum_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wf_post_wf_post_post_id FOREIGN KEY (reply_to)
  REFERENCES wf_post (post_id) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT FK_wf_post_wot_player_player_id FOREIGN KEY (user_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wf_request (
  request_id int(11) NOT NULL AUTO_INCREMENT,
  player_id int(11) NOT NULL,
  c_time datetime NOT NULL,
  status enum ('NEW', 'INPROCESS', 'APPROVED', 'DECLINED') NOT NULL DEFAULT 'NEW',
  m_time datetime NOT NULL,
  PRIMARY KEY (request_id),
  CONSTRAINT FK_wf_request_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_achievment_variant (
  achievment_id int(11) NOT NULL,
  variant_id int(11) NOT NULL,
  name varchar(50) NOT NULL,
  image varchar(255) DEFAULT NULL,
  PRIMARY KEY (achievment_id, variant_id),
  CONSTRAINT FK_wot_achievment_variant_wot_achievment_achievment_id FOREIGN KEY (achievment_id)
  REFERENCES wot_achievment (achievment_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 682
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_clan_history (
  updated_at date NOT NULL,
  clan_id int(11) NOT NULL,
  ivanner_pos int(11) DEFAULT NULL,
  ivanner_strength int(11) DEFAULT NULL,
  ivanner_firepower int(11) DEFAULT NULL,
  ivanner_skill int(11) DEFAULT NULL,
  players_count int(11) DEFAULT NULL,
  players_wn8 decimal(10, 2) DEFAULT NULL,
  players_pp decimal(5, 2) DEFAULT NULL,
  armor_gk_pos int(11) DEFAULT NULL,
  armor_gk_val decimal(10, 2) DEFAULT NULL,
  armor_random_pos int(11) DEFAULT NULL,
  armor_random_val decimal(10, 2) DEFAULT NULL,
  PRIMARY KEY (updated_at, clan_id),
  CONSTRAINT FK_wot_clan_history_wot_clan_clan_id FOREIGN KEY (clan_id)
  REFERENCES wot_clan (clan_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5461
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_achievment (
  player_id int(11) NOT NULL,
  achievment_id int(11) NOT NULL,
  updated_at datetime NOT NULL,
  cnt int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (player_id, achievment_id),
  CONSTRAINT FK_wot_player_achievment FOREIGN KEY (achievment_id)
  REFERENCES wot_achievment (achievment_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_wot_player_achievment_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 245
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_clan (
  entry_date date NOT NULL,
  player_id int(11) NOT NULL,
  clan_id int(11) NOT NULL,
  clan_role_id varchar(50) NOT NULL,
  escape_date date DEFAULT NULL,
  PRIMARY KEY (entry_date, player_id, clan_id),
  CONSTRAINT FK_wot_player_clan_wot_clan_clan_id FOREIGN KEY (clan_id)
  REFERENCES wot_clan (clan_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wot_player_clan_wot_clan_role_clan_role_id FOREIGN KEY (clan_role_id)
  REFERENCES wot_clan_role (clan_role_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_wot_player_clan_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 224
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_glory (
  updated_at date NOT NULL,
  player_id int(11) NOT NULL,
  glory_points int(11) DEFAULT NULL,
  glory_position int(11) DEFAULT NULL,
  PRIMARY KEY (updated_at, player_id),
  CONSTRAINT FK_wot_player_glory_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 49
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_history (
  updated_at date NOT NULL,
  player_id int(11) NOT NULL,
  max_xp int(11) NOT NULL DEFAULT 0,
  effect decimal(10, 2) NOT NULL DEFAULT 0.00,
  wn6 decimal(10, 2) NOT NULL DEFAULT 0.00,
  wn7 decimal(10, 2) DEFAULT NULL,
  wn8 decimal(10, 2) DEFAULT NULL,
  PRIMARY KEY (player_id, updated_at),
  CONSTRAINT FK_wot_player_history1_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 1890
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_statistic (
  player_id int(11) NOT NULL,
  statistic_id int(11) NOT NULL,
  updated_at datetime NOT NULL,
  spotted int(11) NOT NULL DEFAULT 0,
  hits int(11) NOT NULL DEFAULT 0,
  battle_avg_xp int(11) NOT NULL DEFAULT 0,
  draws int(11) NOT NULL DEFAULT 0,
  wins int(11) NOT NULL DEFAULT 0,
  losses int(11) NOT NULL DEFAULT 0,
  capture_points int(11) NOT NULL DEFAULT 0,
  battles int(11) NOT NULL DEFAULT 0,
  damage_dealt int(11) NOT NULL DEFAULT 0,
  hits_percents int(11) NOT NULL DEFAULT 0,
  damage_received int(11) NOT NULL DEFAULT 0,
  shots int(11) NOT NULL DEFAULT 0,
  xp int(11) NOT NULL DEFAULT 0,
  frags int(11) NOT NULL DEFAULT 0,
  survived_battles int(11) NOT NULL DEFAULT 0,
  dropped_capture_points int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (player_id, statistic_id),
  CONSTRAINT FK_wot_player_statistic_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wot_player_statistic_wot_staistic_statistic_id FOREIGN KEY (statistic_id)
  REFERENCES wot_statistic (statistic_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 134
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_post (
  post_id int(11) NOT NULL AUTO_INCREMENT,
  image varchar(255) NOT NULL,
  text text DEFAULT NULL,
  c_time datetime NOT NULL,
  m_time timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  player_id int(11) NOT NULL,
  PRIMARY KEY (post_id),
  CONSTRAINT FK_wot_post_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_province (
  province_id varchar(10) NOT NULL,
  updated_at date NOT NULL,
  province_name varchar(50) NOT NULL,
  territory_id varchar(10) NOT NULL,
  arena_id int(11) NOT NULL,
  revenue int(11) NOT NULL,
  prime_time int(11) NOT NULL,
  type enum ('normal', 'gold') NOT NULL,
  occupancy_time int(11) NOT NULL DEFAULT 0,
  combats_running tinyint(1) NOT NULL,
  PRIMARY KEY (province_id),
  CONSTRAINT FK_wot_province_wot_arena_arena_id FOREIGN KEY (arena_id)
  REFERENCES wot_arena (arena_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_tank (
  tank_id int(11) NOT NULL AUTO_INCREMENT,
  tank_class_id varchar(50) NOT NULL,
  tank_nation_id varchar(50) NOT NULL,
  tank_level int(11) NOT NULL,
  tank_name varchar(100) NOT NULL,
  tank_name_i18n varchar(255) NOT NULL,
  tank_image varchar(255) DEFAULT NULL,
  is_premium tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (tank_id),
  INDEX IDX_wot_tank_tank_level (tank_level),
  UNIQUE INDEX UK_wot_tank_tank_name (tank_name),
  CONSTRAINT FK_wot_tank_wot_tank_class_tank_class_id FOREIGN KEY (tank_class_id)
  REFERENCES wot_tank_class (tank_class_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_wot_tank_wot_tank_nation_tank_nation_id FOREIGN KEY (tank_nation_id)
  REFERENCES wot_tank_nation (tank_nation_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 64818
AVG_ROW_LENGTH = 344
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_teamspeak (
  client_database_id int(11) NOT NULL AUTO_INCREMENT,
  player_id int(11) NOT NULL,
  PRIMARY KEY (client_database_id),
  CONSTRAINT FK_wot_teamspeak_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 84
AVG_ROW_LENGTH = 256
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE tbl_comment (
  id int(11) NOT NULL AUTO_INCREMENT,
  content text NOT NULL,
  status int(11) NOT NULL,
  create_time int(11) DEFAULT NULL,
  author varchar(128) NOT NULL,
  email varchar(128) NOT NULL,
  url varchar(128) DEFAULT NULL,
  post_id int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_comment_post FOREIGN KEY (post_id)
  REFERENCES tbl_post (id) ON DELETE CASCADE ON UPDATE RESTRICT
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
CHARACTER SET utf8
COLLATE utf8_unicode_ci;

CREATE TABLE wf_post_action (
  player_id int(11) NOT NULL,
  post_id int(11) NOT NULL,
  action enum ('view', 'edit', 'star', 'claim', 'vote', 'delete', 'hide') NOT NULL,
  ctime datetime NOT NULL,
  body mediumtext DEFAULT NULL,
  PRIMARY KEY (player_id, post_id, action),
  CONSTRAINT FK_wf_post_view_wf_post_post_id FOREIGN KEY (post_id)
  REFERENCES wf_post (post_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wf_post_view_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_battle (
  battle_id int(11) NOT NULL AUTO_INCREMENT,
  clan_id int(11) NOT NULL,
  battle_time int(11) NOT NULL,
  type_id int(11) NOT NULL,
  c_time datetime NOT NULL,
  province_id varchar(10) NOT NULL,
  prov_id varchar(10) DEFAULT NULL,
  PRIMARY KEY (battle_id),
  CONSTRAINT FK_wot_battle_wot_battle_type_type_id FOREIGN KEY (type_id)
  REFERENCES wot_battle_type (type_id) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT FK_wot_battle_wot_clan_clan_id FOREIGN KEY (clan_id)
  REFERENCES wot_clan (clan_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wot_battle_wot_province_prov_id FOREIGN KEY (prov_id)
  REFERENCES wot_province (province_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wot_battle_wot_province_province_id FOREIGN KEY (province_id)
  REFERENCES wot_province (province_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_clan_province (
  clan_id int(11) NOT NULL,
  province_id varchar(10) NOT NULL,
  date_start date NOT NULL,
  date_end date DEFAULT NULL,
  c_time datetime NOT NULL,
  PRIMARY KEY (clan_id, province_id, date_start),
  INDEX IDX_wot_clan_province_date_end (date_end),
  CONSTRAINT FK_wot_clan_province_wot_clan_clan_id FOREIGN KEY (clan_id)
  REFERENCES wot_clan (clan_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wot_clan_province_wot_province_province_id FOREIGN KEY (province_id)
  REFERENCES wot_province (province_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_achievment_history (
  player_id int(11) NOT NULL,
  achievment_id int(11) NOT NULL,
  updated_at date NOT NULL,
  cnt int(11) NOT NULL,
  PRIMARY KEY (player_id, achievment_id, updated_at),
  CONSTRAINT FK_wot_player_achievment_histo FOREIGN KEY (player_id, achievment_id)
  REFERENCES wot_player_achievment (player_id, achievment_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 131
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_clan_history (
  entry_date date NOT NULL,
  player_id int(11) NOT NULL,
  clan_id int(11) NOT NULL,
  updated_at date NOT NULL,
  clan_role_id varchar(50) NOT NULL,
  PRIMARY KEY (updated_at, player_id, clan_id, entry_date),
  CONSTRAINT FK_wot_player_clan_history1 FOREIGN KEY (entry_date, player_id, clan_id)
  REFERENCES wot_player_clan (entry_date, player_id, clan_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 58
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_statistic_history (
  player_id int(11) NOT NULL,
  statistic_id int(11) NOT NULL,
  updated_at date NOT NULL,
  spotted int(11) NOT NULL DEFAULT 0,
  hits int(11) NOT NULL DEFAULT 0,
  battle_avg_xp int(11) NOT NULL DEFAULT 0,
  draws int(11) NOT NULL DEFAULT 0,
  wins int(11) NOT NULL DEFAULT 0,
  losses int(11) NOT NULL DEFAULT 0,
  capture_points int(11) NOT NULL DEFAULT 0,
  battles int(11) NOT NULL DEFAULT 0,
  damage_dealt int(11) NOT NULL DEFAULT 0,
  hits_percents int(11) NOT NULL DEFAULT 0,
  damage_received int(11) NOT NULL DEFAULT 0,
  shots int(11) NOT NULL DEFAULT 0,
  xp int(11) NOT NULL DEFAULT 0,
  frags int(11) NOT NULL DEFAULT 0,
  survived_battles int(11) NOT NULL DEFAULT 0,
  dropped_capture_points int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (updated_at, player_id, statistic_id),
  CONSTRAINT FK_wot_player_statistic_histor FOREIGN KEY (player_id, statistic_id)
  REFERENCES wot_player_statistic (player_id, statistic_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 243
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_tank (
  player_id int(11) NOT NULL,
  tank_id int(11) NOT NULL,
  updated_at datetime DEFAULT NULL,
  created_at datetime NOT NULL,
  wins int(11) NOT NULL DEFAULT 0,
  battles int(11) NOT NULL DEFAULT 0,
  mark_of_mastery int(1) UNSIGNED NOT NULL DEFAULT 0,
  in_garage tinyint(1) DEFAULT NULL,
  max_frags int(11) DEFAULT NULL,
  max_xp int(11) DEFAULT NULL,
  PRIMARY KEY (player_id, tank_id),
  CONSTRAINT FK_wot_player_tank_wot_player_player_id FOREIGN KEY (player_id)
  REFERENCES wot_player (player_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wot_player_tank_wot_tank_tank_id FOREIGN KEY (tank_id)
  REFERENCES wot_tank (tank_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 150
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_presense (
  client_database_id int(11) NOT NULL,
  updated_at datetime NOT NULL,
  PRIMARY KEY (client_database_id, updated_at),
  CONSTRAINT FK_wot_presense_wot_teamspeak_client_database_id FOREIGN KEY (client_database_id)
  REFERENCES wot_teamspeak (client_database_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 42
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_province_history (
  province_id varchar(10) NOT NULL,
  updated_at date NOT NULL,
  province_name varchar(50) NOT NULL,
  territory_id varchar(10) NOT NULL,
  map_id int(11) NOT NULL,
  revenue int(11) NOT NULL,
  prime_time int(11) NOT NULL,
  PRIMARY KEY (province_id, updated_at),
  CONSTRAINT FK_wot_province_history_wot_province_province_id FOREIGN KEY (province_id)
  REFERENCES wot_province (province_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_wn8_etv (
  IDNum int(11) NOT NULL,
  name varchar(255) NOT NULL,
  frag decimal(10, 2) NOT NULL,
  dmg decimal(10, 2) NOT NULL,
  spot decimal(10, 2) NOT NULL,
  def decimal(10, 2) NOT NULL,
  win decimal(10, 2) NOT NULL,
  Tier int(11) NOT NULL,
  Nation varchar(255) DEFAULT NULL,
  Class varchar(255) DEFAULT NULL,
  PRIMARY KEY (IDNum),
  CONSTRAINT FK_wot_wn8_etv_wot_tank_tank_id FOREIGN KEY (IDNum)
  REFERENCES wot_tank (tank_id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = INNODB
AVG_ROW_LENGTH = 187
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_tank_history (
  player_id int(11) NOT NULL,
  tank_id int(11) NOT NULL,
  updated_at date NOT NULL,
  wins int(11) NOT NULL DEFAULT 0,
  battles int(11) NOT NULL DEFAULT 0,
  mark_of_mastery int(1) UNSIGNED NOT NULL DEFAULT 0,
  in_garage tinyint(1) DEFAULT 0,
  max_frags int(11) DEFAULT NULL,
  max_xp int(11) DEFAULT NULL,
  PRIMARY KEY (player_id, tank_id, updated_at),
  CONSTRAINT FK_wot_player_tank_history1 FOREIGN KEY (player_id, tank_id)
  REFERENCES wot_player_tank (player_id, tank_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 143
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_tank_statistic (
  player_id int(11) NOT NULL,
  tank_id int(11) NOT NULL,
  statistic_id int(11) NOT NULL,
  updated_at datetime DEFAULT NULL,
  spotted int(11) NOT NULL DEFAULT 0,
  hits int(11) NOT NULL DEFAULT 0,
  battle_avg_xp int(11) NOT NULL DEFAULT 0,
  draws int(11) NOT NULL DEFAULT 0,
  wins int(11) NOT NULL DEFAULT 0,
  losses int(11) NOT NULL DEFAULT 0,
  capture_points int(11) NOT NULL DEFAULT 0,
  battles int(11) NOT NULL DEFAULT 0,
  damage_dealt int(11) NOT NULL DEFAULT 0,
  hits_percents int(11) NOT NULL DEFAULT 0,
  damage_received int(11) NOT NULL DEFAULT 0,
  shots int(11) NOT NULL DEFAULT 0,
  xp int(11) NOT NULL DEFAULT 0,
  frags int(11) NOT NULL DEFAULT 0,
  survived_battles int(11) NOT NULL DEFAULT 0,
  dropped_capture_points int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (player_id, tank_id, statistic_id),
  CONSTRAINT FK_wot_player_tank_statistic FOREIGN KEY (player_id, tank_id)
  REFERENCES wot_player_tank (player_id, tank_id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_wot_player_tank_statistic_wot_staistic_statistic_id FOREIGN KEY (statistic_id)
  REFERENCES wot_statistic (statistic_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 302
CHARACTER SET utf8
COLLATE utf8_general_ci;

CREATE TABLE wot_player_tank_statistic_history (
  player_id int(11) NOT NULL,
  tank_id int(11) NOT NULL,
  statistic_id int(11) NOT NULL,
  updated_at date NOT NULL,
  spotted int(11) DEFAULT NULL,
  hits int(11) DEFAULT NULL,
  battle_avg_xp int(11) DEFAULT NULL,
  draws int(11) DEFAULT NULL,
  wins int(11) NOT NULL DEFAULT 0,
  losses int(11) DEFAULT NULL,
  capture_points int(11) DEFAULT NULL,
  battles int(11) NOT NULL DEFAULT 0,
  damage_dealt int(11) DEFAULT NULL,
  damage_received int(11) DEFAULT NULL,
  hits_percents int(11) DEFAULT NULL,
  shots int(11) DEFAULT NULL,
  xp int(11) DEFAULT NULL,
  frags int(11) DEFAULT NULL,
  survived_battles int(11) DEFAULT NULL,
  dropped_capture_points int(11) DEFAULT NULL,
  PRIMARY KEY (player_id, tank_id, statistic_id, updated_at),
  CONSTRAINT FK_wot_player_tank_statistic_h FOREIGN KEY (player_id, tank_id, statistic_id)
  REFERENCES wot_player_tank_statistic (player_id, tank_id, statistic_id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 106
CHARACTER SET utf8
COLLATE utf8_general_ci;

DELIMITER $$

CREATE
DEFINER = 'root'@'localhost'
TRIGGER tr_wot_clan_update
AFTER UPDATE
ON wot_clan
FOR EACH ROW
BEGIN
  INSERT INTO wot_clan_history (updated_at,
  clan_id,
  ivanner_pos,
  ivanner_strength,
  ivanner_firepower,
  ivanner_skill,
  players_count,
  players_pp,
  players_wn8,
  armor_gk_pos,
  armor_gk_val,
  armor_random_pos,
  armor_random_val)
    VALUES (CURDATE(), new.clan_id, new.ivanner_pos, new.ivanner_strength, new.ivanner_firepower, new.ivanner_skill, new.players_count, new.players_pp, new.players_wn8, new.armor_gk_pos, new.armor_gk_val, new.armor_random_pos, new.armor_random_val)
  ON DUPLICATE KEY UPDATE
  ivanner_pos = new.ivanner_pos,
  ivanner_strength = new.ivanner_strength,
  ivanner_firepower = new.ivanner_firepower,
  ivanner_skill = new.ivanner_skill,
  players_count = new.players_count,
  players_pp = new.players_pp,
  players_wn8 = new.players_wn8,
  armor_gk_pos = new.armor_gk_pos,
  armor_gk_val = new.armor_gk_val,
  armor_random_pos = new.armor_random_pos,
  armor_random_val = new.armor_random_val;
END
$$

CREATE
DEFINER = 'root'@'localhost'
TRIGGER tr_wot_player_tank_update
AFTER UPDATE
ON wot_player_tank
FOR EACH ROW
BEGIN
  SET @updated_at = (SELECT
    updated_at
  FROM wot_player wp
  WHERE wp.player_id = new.player_id);
  IF new.battles > old.battles THEN
    INSERT INTO wot_player_tank_history (updated_at
    , player_id
    , tank_id
    , max_xp
    , wins
    , battles
    , max_frags
    , mark_of_mastery
    , in_garage)
      VALUES (@updated_at, new.player_id, new.tank_id, new.max_xp, new.wins, new.battles, new.max_frags, new.mark_of_mastery, new.in_garage)
    ON DUPLICATE KEY UPDATE max_xp = new.max_xp, wins = new.wins, battles = new.battles, max_frags = new.max_frags, mark_of_mastery = new.mark_of_mastery, in_garage = new.in_garage;
  END IF;
END
$$

CREATE
DEFINER = 'root'@'localhost'
TRIGGER wot_player_tank_statistic_update
AFTER UPDATE
ON wot_player_tank_statistic
FOR EACH ROW
BEGIN
  IF new.battles <> old.battles THEN
    INSERT INTO wot_player_tank_statistic_history (player_id
    , tank_id
    , statistic_id
    , updated_at
    , spotted
    , hits
    , battle_avg_xp
    , draws
    , wins
    , losses
    , capture_points
    , battles
    , damage_dealt
    , hits_percents
    , damage_received
    , shots
    , xp
    , frags
    , survived_battles
    , dropped_capture_points)
      VALUES (new.player_id, new.tank_id, new.statistic_id, new.updated_at, new.spotted, new.hits, new.battle_avg_xp, new.draws, new.wins, new.losses, new.capture_points, new.battles, new.damage_dealt, new.hits_percents, new.damage_received, new.shots, new.xp, new.frags, new.survived_battles, new.dropped_capture_points)
    ON DUPLICATE KEY UPDATE
    spotted = new.spotted,
    hits = new.hits,
    battle_avg_xp = new.battle_avg_xp,
    draws = new.draws,
    wins = new.wins,
    losses = new.losses,
    capture_points = new.capture_points,
    battles = new.battles,
    damage_dealt = new.damage_dealt,
    hits_percents = new.hits_percents,
    damage_received = new.damage_received,
    shots = new.shots,
    xp = new.xp,
    frags = new.frags,
    survived_battles = new.survived_battles,
    dropped_capture_points = new.dropped_capture_points;
  END IF;
END
$$

CREATE
DEFINER = 'root'@'localhost'
TRIGGER tr_wot_player_achievment_update
AFTER UPDATE
ON wot_player_achievment
FOR EACH ROW
BEGIN
  INSERT INTO wot_player_achievment_history (updated_at, player_id, achievment_id, cnt)
    VALUES (new.updated_at, new.player_id, new.achievment_id, new.cnt)
  ON DUPLICATE KEY UPDATE cnt = new.cnt;
END
$$

CREATE
DEFINER = 'root'@'localhost'
TRIGGER tr_wot_player_clan_update
AFTER UPDATE
ON wot_player_clan
FOR EACH ROW
BEGIN
  INSERT INTO wot_player_clan_history (entry_date, player_id, clan_id, clan_role_id, updated_at)
    VALUES (old.entry_date, old.player_id, old.clan_id, old.clan_role_id, CURDATE())
  ON DUPLICATE KEY UPDATE clan_role_id = old.clan_role_id;
END
$$

CREATE
DEFINER = 'root'@'localhost'
TRIGGER tr_wot_player_statistic_update
AFTER UPDATE
ON wot_player_statistic
FOR EACH ROW
BEGIN
  INSERT INTO wot_player_statistic_history (player_id
  , statistic_id
  , updated_at
  , spotted
  , hits
  , battle_avg_xp
  , draws
  , wins
  , losses
  , capture_points
  , battles
  , damage_dealt
  , hits_percents
  , damage_received
  , shots
  , xp
  , frags
  , survived_battles
  , dropped_capture_points)
    VALUES (new.player_id, new.statistic_id, new.updated_at, new.spotted, new.hits, new.battle_avg_xp, new.draws, new.wins, new.losses, new.capture_points, new.battles, new.damage_dealt, new.hits_percents, new.damage_received, new.shots, new.xp, new.frags, new.survived_battles, new.dropped_capture_points)
  ON DUPLICATE KEY UPDATE
  spotted = new.spotted,
  hits = new.hits,
  battle_avg_xp = new.battle_avg_xp,
  draws = new.draws,
  wins = new.wins,
  losses = new.losses,
  capture_points = new.capture_points,
  battles = new.battles,
  damage_dealt = new.damage_dealt,
  hits_percents = new.hits_percents,
  damage_received = new.damage_received,
  shots = new.shots,
  xp = new.xp,
  frags = new.frags,
  survived_battles = new.survived_battles,
  dropped_capture_points = new.dropped_capture_points;
END
$$

CREATE
DEFINER = 'root'@'localhost'
TRIGGER tr_wot_player_update
AFTER UPDATE
ON wot_player
FOR EACH ROW
BEGIN
  INSERT INTO wot_player_history (updated_at, player_id, max_xp, effect, wn6, wn7, wn8)
    VALUES (new.updated_at, new.player_id, new.max_xp, new.effect, new.wn6, new.wn7, new.wn8)
  ON DUPLICATE KEY UPDATE max_xp = new.max_xp, effect = new.effect, wn6 = new.wn6, wn7 = new.wn7, wn8 = new.wn8;
END
$$

DELIMITER ;