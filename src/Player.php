<?php

namespace Coderjerk\Cupsets;

use Coderjerk\Cupsets\Enums\Branch;

class Player
{
    public function create(string $name): void
    {
        $points = 0;
        $goal_difference = 0;
        $db = DB::connect();
        $sql = "INSERT INTO players (player_name, player_points, player_goal_difference) VALUES (:name, :points, :goal_difference)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':points', $points);
        $stmt->bindValue(':goal_difference', $goal_difference);
        $stmt->execute();
    }

    public static function update(int $id, string $param, mixed $value)
    {
        $db = DB::connect();
        $sql = "UPDATE players SET $param = :param WHERE player_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':param', $value);
        $stmt->execute();
        return self::getPlayer($id);
    }

    public static function getPlayer(int $id)
    {
        $db = DB::connect();
        $sql = "SELECT * FROM players WHERE player_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getPlayerByTeamName(?string $team_name)
    {
        if (!$team_name) {
            return '?';
        }
        $player_id = Team::getTeamByName(str_replace(' ', '_', $team_name))['player_id'];

        $player = self::getPlayer($player_id);

        return $player['player_name'];

    }

    public static function all(): ?array
    {
        $players = [];
        $db = DB::connect();
        $sql = "SELECT * FROM players ORDER BY player_points DESC,player_goal_difference DESC, player_id DESC;";
        $stmt = $db->query($sql);

        while ($player = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $players[] = [
                'player_id' => $player['player_id'],
                'player_name' => $player['player_name'],
                'player_points' => $player['player_points'],
                'player_goal_difference' => $player['player_goal_difference'],
                'branch' => $player['branch'],
                'games_played' => $player['games_played'],
                'moral_winner' => $player['moral_winner'],
                'moral_loser' => $player['moral_loser'],
                'league_winner' => $player['league_winner'],
                'cup_winner' => $player['cup_winner'],
                'batting_average' => $player['batting_average'],
                'eliminated' => $player['eliminated'],
                'form' => $player['form'],
            ];
        }
        return $players;
    }

    public static function playerTeams($id): ?array
    {
        return Team::getTeamsByPlayerId($id);
    }

    public static function playerTeamNames($id): string
    {
        $teams = self::playerTeams($id);
        $names = [];
        foreach ($teams as $team) {
            $names[] = $team['team_name'];
        }
        return implode(', ', str_replace('_', ' ', $names));
    }

    protected static function mergeForm($form): string
    {
        $a = $form[0];
        $b = $form[1];

        $merged = [];

        foreach (array_map(null, $a, $b) as [$x, $y]) {
            if ($x !== null && $x !== '') {
                $merged[] = $x;
            }
            if ($y !== null && $y !== '') {
                $merged[] = $y;
            }
        }

        return implode('', $merged);
    }

    public static function updatePlayerScore($id)
    {
        $player = self::getPlayer($id);
        $goal_difference = 0;
        $points = 0;
        $teams = self::playerTeams($id);
        $merged_form = [];
        $games_played = 0;
        $goals_scored = 0;
        $branch = self::assignBranch($player['player_name'])->value;


        foreach ($teams as $team) {
            $goal_difference = $goal_difference + $team['team_goals_for'];
            $goal_difference = $goal_difference - $team['team_goals_against'];
            //Not sure if points incremented after group stage in api so calculating manually
            $points = $points + $team['won'] * 3;
            $points = $points + $team['draw'] * 1;
            $merged_form[] = array_map('trim', explode(',', $team['form']));
            $games_played = $games_played + $team['played_games'];
            $goals_scored = $goals_scored + $team['team_goals_for'];
        }

        $merged_form = self::mergeForm($merged_form);

        self::update($player['player_id'], 'form', $merged_form);
        self::update($player['player_id'], 'player_goal_difference', $goal_difference);
        self::update($player['player_id'], 'player_points', $points);
        self::update($player['player_id'], 'games_played', $games_played);
        self::update($player['player_id'], 'branch', $branch);
        self::update($player['player_id'], 'player_goals_scored', $goals_scored);
        if ($player['games_played'] >= 1) {
            $batting_average = $player['player_goals_scored'] / $player['games_played'];
            self::update($player['player_id'], 'batting_average', $batting_average);
        }
        return self::getPlayer($id);
    }

    public static function assignBranch(string $player_name): ?Branch
    {
        $ardpatrick = [
            'Dan',
            'Ellen',
            'Luke',
            'Nina'
        ];

        $jamestown = [
            'Clodagh',
            'Ewan',
            'Isla',
            'Pat',
            'Paula',
        ];

        $charleville = [
            'Evie',
            'Kieran',
            'Mary',
        ];

        $ardskeagh = [
            'Grandad',
            'Nana',
            'John'
        ];

        $botland = [
            'Bot 1',
            'Bot 2',
            'Bot 3',
            'Bot 4',
        ];

        $limerick = [
            'Andy',
            'Emily',
            'Niamh',
            'Oscar',
            'Sadie',
        ];

        if (in_array($player_name, $ardpatrick)) {
            return Branch::ARDPATRICK;
        }

        if (in_array($player_name, $ardskeagh)) {
            return Branch::ARDSKEAGH;
        }

        if (in_array($player_name, $botland)) {
            return Branch::BOTLAND;
        }

        if (in_array($player_name, $charleville)) {
            return Branch::CHARLEVILLE;
        }

        if (in_array($player_name, $jamestown)) {
            return Branch::JAMESTOWN;
        }

        if (in_array($player_name, $limerick)) {
            return Branch::LIMERICK;
        }

        return null;
    }

}
