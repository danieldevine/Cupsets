<?php

namespace Coderjerk\Cupsets\Controllers;

use Coderjerk\Cupsets\Views;

class LeaderboardController
{
    public static function players(): array
    {
        return HomeController::updatedPlayers();
    }

    public function show(): string
    {
        return Views::render('leaderboard', self::getWinners());
    }

    public static function calculateGoldenBoot($players): array
    {
        $top_scorers = [];

        foreach ($players as $player) {
            $top_scorers[$player['player_name']] = $player['player_goals_scored'];
        }

        arsort($top_scorers, SORT_NUMERIC);

        return self::medalise($top_scorers);

    }

    public static function calculateMoralVictor($players): array
    {
        $morality_ranking = [];
        $count = 0;

        // remove the actual winners
        $players = array_slice($players, 3);

        foreach ($players as $player) {
            $mvq = $player['player_id'] - ($count + 1);
            $mvq = $mvq - 3; //account for removed winners
            $morality_ranking[$player['player_name']] = $mvq;
            $count++;
        }

        return self::medalise($morality_ranking);

    }

    public static function sortWinnersAndLosers($players): array
    {
        $max = max($players);
        $winners = array_filter($players, fn($v) => $v === $max);
        $rest = array_diff($players, $winners);

        return [
            'winners' => $winners,
            'rest' => $rest
        ];
    }

    public static function medalise($players): array
    {
        $gold = self::sortWinnersAndLosers($players)['winners'];
        $remainder = self::sortWinnersAndLosers($players)['rest'];
        $silver = self::sortWinnersAndLosers($remainder)['winners'];
        $remainder = self::sortWinnersAndLosers($remainder)['rest'];
        $bronze = self::sortWinnersAndLosers($remainder)['winners'];

        return [
            'gold' => $gold,
            'silver' => $silver,
            'bronze' => $bronze,
        ];

    }

    public static function calculateLeagueChampion($players)
    {
        return [
            'gold' => $players[0],
            'silver' => $players[1],
            'bronze' => $players[2],
        ];
    }

    public static function calculateBattingAverageChampion($players): array
    {
        $best_batsmen = [];

        foreach ($players as $player) {
            $best_batsmen[$player['player_name']] = $player['batting_average'];
        }

        arsort($best_batsmen, SORT_NUMERIC);

        return self::medalise($best_batsmen);
    }

    public static function getWinners(): array
    {
        $players = self::players();

        return [
            'league_champion' => self::calculateLeagueChampion($players),
            'moral_victor' => self::calculateMoralVictor($players),
            'golden_boot' => self::calculateGoldenBoot($players),
            'batting_average_champion' => self::calculateBattingAverageChampion($players),
        ];
    }
}
