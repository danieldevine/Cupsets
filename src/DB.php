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
        self::addExtraTeamColumns();
        self::addExtraPlayersColumns();
    }

    public static function createPlayersTable(): void
    {
        self::connect()->exec(
            'CREATE TABLE IF NOT EXISTS players (
                player_id              INTEGER PRIMARY KEY AUTOINCREMENT,
                player_name            TEXT NOT NULL,
                player_points          INTEGER NOT NULL,
                player_goal_difference INTEGER NOT NULL
            )'
        );
    }

    public static function createTeamsTable(): void
    {
        self::connect()->exec(
            'CREATE TABLE IF NOT EXISTS teams (
                team_id            INTEGER PRIMARY KEY AUTOINCREMENT,
                team_name          TEXT NOT NULL,
                team_points        INTEGER NOT NULL,
                team_goals_for     INTEGER NOT NULL,
                team_goals_against INTEGER NOT NULL,
                player_id          INTEGER NOT NULL,
                FOREIGN KEY (player_id)
                    REFERENCES players(player_id)
                        ON UPDATE CASCADE
                        ON DELETE CASCADE
            )'
        );
    }

    public static function addExtraTeamColumns(): void
    {
        $pdo = self::connect();

        $newColumns = [
            'position' => 'INTEGER NOT NULL DEFAULT 0',
            'played_games' => 'INTEGER NOT NULL DEFAULT 0',
            'form' => "TEXT    NOT NULL DEFAULT ''",
            'won' => 'INTEGER NOT NULL DEFAULT 0',
            'draw' => 'INTEGER NOT NULL DEFAULT 0',
            'lost' => 'INTEGER NOT NULL DEFAULT 0',
            'goal_difference' => 'INTEGER NOT NULL DEFAULT 0',
        ];

        $existing = array_flip(
            $pdo->query('PRAGMA table_info(teams)')->fetchAll(PDO::FETCH_COLUMN, 1)
        );

        $missing = array_diff_key($newColumns, $existing);
        if (!$missing) {
            return;
        }

        $pdo->beginTransaction();
        try {
            foreach ($missing as $column => $definition) {
                $pdo->exec("ALTER TABLE teams ADD COLUMN {$column} {$definition}");
            }
            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function addExtraPlayersColumns(): void
    {
        $pdo = self::connect();

        $newColumns = [
            'games_played' => 'INTEGER NOT NULL DEFAULT 0',
            'form' => "TEXT NOT NULL DEFAULT ''",
            'branch' => "TEXT NOT NULL DEFAULT ''",
            'moral_winner' => 'INTEGER DEFAULT 0 NOT NULL',
            'moral_loser' => 'INTEGER DEFAULT 0 NOT NULL',
            'league_winner' => 'INTEGER DEFAULT 0 NOT NULL',
            'cup_winner' => 'INTEGER DEFAULT 0 NOT NULL',
            'batting_average' => 'INTEGER DEFAULT 0 NOT NULL',
            'eliminated' => 'INTEGER DEFAULT 0 NOT NULL',
        ];

        $existing = array_flip(
            $pdo->query('PRAGMA table_info(players)')->fetchAll(PDO::FETCH_COLUMN, 1)
        );

        $missing = array_diff_key($newColumns, $existing);
        if (!$missing) {
            return;
        }

        $pdo->beginTransaction();
        try {
            foreach ($missing as $column => $definition) {
                $pdo->exec("ALTER TABLE players ADD COLUMN {$column} {$definition}");
            }
            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
