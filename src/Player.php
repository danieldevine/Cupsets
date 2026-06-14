<?php

namespace Coderjerk\Cupsets;

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
                'player_goal_difference' => $player['player_goal_difference']
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

    public static function updatePlayerScore($id)
    {
        $player = self::getPlayer($id);
        $goal_difference = 0;
        $points = 0;
        $teams = self::playerTeams($id);

        foreach ($teams as $team) {
            $goal_difference = $goal_difference + $team['team_goals_for'];
            $goal_difference = $goal_difference - $team['team_goals_against'];
            $points = $points + $team['team_points'];
        }

        self::update($player['player_id'], 'player_goal_difference', $goal_difference);
        self::update($player['player_id'], 'player_points', $points);

        return self::getPlayer($id);
    }

}
