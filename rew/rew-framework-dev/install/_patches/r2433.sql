ALTER TABLE `history_users` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
ALTER TABLE `history_users` CHANGE `type` `type` ENUM( 'Agent', 'Lead' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;