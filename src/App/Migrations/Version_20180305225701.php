<?php

namespace App\Migrations;


class Version_20180305225701 extends AbstractVersion
{
    public $description = 'create user_in_game table';

    public function up()
    {
        $this->executeQuery(
            'CREATE TABLE IF NOT EXISTS `user_in_game` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `user_id` INT(11) NOT NULL,
            `game_id` INT(11) NOT NULL,
            `joined_dt` DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY (`game_id`, `user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;'
        );
    }
}