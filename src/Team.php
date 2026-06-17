<?php

namespace Coderjerk\Cupsets;

class Team
{
    public function create(string $name, int $player_id): void
    {
        $points = 0;
        $goals_for = 0;
        $goals_against = 0;
        $db = DB::connect();
        $sql = "INSERT INTO teams (team_name,team_points,team_goals_for,team_goals_against,player_id) VALUES (:name, :points, :goals_for, :goals_against, :player_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':points', $points);
        $stmt->bindValue(':goals_for', $goals_for);
        $stmt->bindValue(':goals_against', $goals_against);
        $stmt->bindValue(':player_id', $player_id);
        $stmt->execute();
    }

    public static function update(int $id, string $param, mixed $value)
    {
        $db = DB::connect();
        $sql = "UPDATE teams SET $param = :param WHERE team_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':param', $value);
        $stmt->execute();
        return self::getTeam($id);
    }

    public static function getTeam(int $id)
    {
        $db = DB::connect();
        $sql = "SELECT * FROM teams WHERE team_id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function getTeamByName(string $name)
    {
        $db = DB::connect();
        $sql = "SELECT * FROM teams WHERE team_name = :name";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        return $stmt->fetch();
    }

    public static function all(): ?array
    {
        $teams = [];
        $db = DB::connect();
        $sql = "SELECT * FROM teams";
        $stmt = $db->query($sql);

        while ($team = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $teams[] = [
                'team_id' => $team['team_id'],
                'team_name' => $team['team_name'],
                'team_points' => $team['team_points'],
                'team_goals_for' => $team['team_goals_for'],
                'team_goals_against' => $team['team_goals_against']
            ];
        }
        return $teams;
    }

    public static function getTeamsByPlayerId(int $player_id): ?array
    {
        $teams = [];
        $db = DB::connect();
        $sql = "SELECT * FROM teams WHERE player_id = :player_id";
        $stmt = $db->query($sql);
        $stmt->bindValue(':player_id', $player_id);
        $stmt->execute();

        while ($team = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $teams[] = [
                'team_id' => $team['team_id'],
                'team_name' => $team['team_name'],
                'team_points' => $team['team_points'],
                'team_goals_for' => $team['team_goals_for'],
                'team_goals_against' => $team['team_goals_against']
            ];
        }
        return $teams;
    }

    public static function updateTeamScores(int $team_id)
    {
        $team = self::getTeam($team_id);
        $team_name = $team['team_name'];
        $competition = new Competition('2000');
        $standings = $competition->standings();
        $tables = [];
        // it's broken down into many tables for the different rounds.
        foreach ($standings?->standings as $standing) {
            if ($standing->type === 'TOTAL') {
                $tables[] = $standing->table;
            }
        }

        foreach ($tables as $table) {
            $item = array_find($table, fn($item) => $item->team->name == str_replace('_', ' ', $team_name));
            self::update($team_id, 'team_goals_against', $item->goalsAgainst);
            self::update($team_id, 'team_goals_for', $item->goalsFor);
            self::update($team_id, 'team_points', $item->points);
        }

        return self::getTeam($team_id);
    }

}
