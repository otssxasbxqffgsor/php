ALTER TABLE `history_data` DROP INDEX `event`,
ADD PRIMARY KEY (`event`),
ENGINE=InnoDB ROW_FORMAT=COMPRESSED KEY_BLOCK_SIZE=8;