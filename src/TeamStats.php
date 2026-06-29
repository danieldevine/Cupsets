<?php

namespace Coderjerk\Cupsets;


class TeamStats
{
    public static function fromMatches(array $matches): array
    {
        usort($matches, fn($match_a, $match_b) => strcmp($match_a->utcDate ?? '', $match_b->utcDate ?? ''));

        $teams = [];

        foreach ($matches as $match) {
            if (($match->status ?? '') !== 'FINISHED') {
                continue;
            }

            $home_team = $match->homeTeam;
            $away_team = $match->awayTeam;

            self::ensureTeam($teams, $home_team);
            self::ensureTeam($teams, $away_team);

            [$home_goals, $away_goals] = self::matchGoals($match->score);

            self::recordGoals($teams[$home_team->id], $home_goals, $away_goals);
            self::recordGoals($teams[$away_team->id], $away_goals, $home_goals);

            if ($home_goals > $away_goals) {
                self::recordResult($teams[$home_team->id], 'won', 'W');
                self::recordResult($teams[$away_team->id], 'lost', 'L');
            } elseif ($away_goals > $home_goals) {
                self::recordResult($teams[$away_team->id], 'won', 'W');
                self::recordResult($teams[$home_team->id], 'lost', 'L');
            } else {
                self::recordResult($teams[$home_team->id], 'draw', 'D');
                self::recordResult($teams[$away_team->id], 'draw', 'D');
            }
        }

        foreach ($teams as &$team) {
            $team['points'] = $team['won'] * 3 + $team['draw'];
            $team['goal_difference'] = $team['team_goals_for'] - $team['team_goals_against'];
            $team['form'] = implode(',', array_slice($team['form'], -5));
        }
        unset($team);

        return $teams;
    }

    private static function ensureTeam(array &$teams, object $team): void
    {
        $teams[$team->id] ??= [
            'team_id' => $team->id,
            'team_name' => $team->name ?? null,
            'played_games' => 0,
            'won' => 0,
            'draw' => 0,
            'lost' => 0,
            'team_goals_for' => 0,
            'team_goals_against' => 0,
            'form' => [],
        ];
    }

    private static function recordGoals(array &$team, int $goals_for, int $goals_against): void
    {
        $team['played_games']++;
        $team['team_goals_for'] += $goals_for;
        $team['team_goals_against'] += $goals_against;
    }

    private static function recordResult(array &$team, string $result_column, string $form_letter): void
    {
        $team[$result_column]++;
        $team['form'][] = $form_letter;
    }

    private static function matchGoals(object $score): array
    {
        $full_time = $score->fullTime ?? null;
        $penalties = $score->penalties ?? null;

        $home_goals = self::sideGoals($full_time, 'home');
        $away_goals = self::sideGoals($full_time, 'away');

        if (($score->duration ?? 'REGULAR') === 'PENALTY_SHOOTOUT' && $penalties !== null) {
            $home_goals -= self::sideGoals($penalties, 'home');
            $away_goals -= self::sideGoals($penalties, 'away');
        }

        return [$home_goals, $away_goals];
    }

    private static function sideGoals(?object $score_node, string $side): int
    {
        if ($score_node === null) {
            return 0;
        }
        return (int)($score_node->{$side} ?? $score_node->{$side . 'Team'} ?? 0);
    }
}
