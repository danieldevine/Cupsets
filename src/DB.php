<?php

namespace Coderjerk\Cupsets;

use PDO;

class DB
{
    public static string $db = '../database/cupsets.db';

    public static function connect(): PDO
    {
        return new PDO("sqlite:" . self::$db);
    }

    public static function init(): void
    {
        self::connect();
        self::createPlayersTable();
        self::createTeamsTable();
    }

    public static function createPlayersTable(): void
    {
        self::connect()->exec("CREATE TABLE IF NOT EXISTS players (player_id INTEGER PRIMARY KEY AUTOINCREMENT,player_name TEXT NOT NULL,player_points integer NOT NULL,player_goal_difference integer NOT NULL )");
    }

    public static function createTeamsTable(): void
    {
        self::connect()->exec(
            "CREATE TABLE IF NOT EXISTS teams (team_id INTEGER PRIMARY KEY AUTOINCREMENT,team_name TEXT NOT NULL,team_points integer NOT NULL,team_goals_for integer NOT NULL,team_goals_against integer NOT NULL,player_id integer NOT NULL, FOREIGN KEY (player_id) REFERENCES players(player_id) ON UPDATE CASCADE ON DELETE CASCADE)");
    }

}
