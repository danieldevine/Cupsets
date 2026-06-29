<?php

namespace Coderjerk\Cupsets;

class Team
{
    protected static function getData(false|\PDOStatement $stmt, array $teams): array
    {
        while ($team = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $teams[] = [
                'team_id' => $team['team_id'],
                'team_name' => $team['team_name'],
                'team_points' => $team['team_points'],
                'team_goals_for' => $team['team_goals_for'],
                'team_goals_against' => $team['team_goals_against'],
                'position' => $team['position'],
                'played_games' => $team['played_games'],
                'form' => $team['form'],
                'won' => $team['won'],
                'lost' => $team['lost'],
                'draw' => $team['draw'],
                'goal_difference' => $team['goal_difference'],
            ];
        }
        return $teams;
    }

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

        return self::getData($stmt, $teams);
    }

    public static function getTeamsByPlayerId(int $player_id): ?array
    {
        $teams = [];
        $db = DB::connect();
        $sql = "SELECT * FROM teams WHERE player_id = :player_id";
        $stmt = $db->query($sql);
        $stmt->bindValue(':player_id', $player_id);
        $stmt->execute();

        return self::getData($stmt, $teams);
    }

    public static function updateTeamScores(int $team_id)
    {
        $team = self::getTeam($team_id);
        $team_name = str_replace('_', ' ', $team['team_name']);

        $competition = new Competition('2000');
        $payload = $competition->matches();

        $all_stats = TeamStats::fromMatches($payload->matches);

        $stats = array_find($all_stats, fn($row) => $row['team_name'] === $team_name);

        if ($stats === null) {
            return self::getTeam($team_id);
        }

        self::update($team_id, 'team_goals_against', $stats['team_goals_against']);
        self::update($team_id, 'team_goals_for', $stats['team_goals_for']);
        self::update($team_id, 'team_points', $stats['points']);
        self::update($team_id, 'played_games', $stats['played_games']);
        self::update($team_id, 'form', $stats['form']);
        self::update($team_id, 'won', $stats['won']);
        self::update($team_id, 'lost', $stats['lost']);
        self::update($team_id, 'draw', $stats['draw']);
        self::update($team_id, 'goal_difference', $stats['goal_difference']);

        return self::getTeam($team_id);
    }
}
