-- Add mail settings column to support third-party mail providers
ALTER TABLE `default_info` ADD `mail_settings` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `auto_optout_actions` ;