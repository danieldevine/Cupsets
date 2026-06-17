<?php

namespace Coderjerk\Cupsets\Controllers;

use Coderjerk\Cupsets\Competition;
use Coderjerk\Cupsets\Game;
use Coderjerk\Cupsets\Views;

class MatchdayController
{
    public function competition(): Competition
    {
        return new Competition('2000');
    }

    public function getMatchday($matchday): array
    {
        $tournament = $this->competition()->matches();

        $games = [];

        foreach ($tournament->matches as $match) {
            $games[] = new Game($match);
        }

        $live = array_filter($games, fn($game) => $game->matchday === $matchday && $game->status === 'IN_PLAY');
        $completed = array_filter($games, fn($game) => $game->matchday === $matchday && $game->status === 'FINISHED');
        $upcoming = array_filter($games, fn($game) => $game->matchday === $matchday && $game->status !== 'FINISHED' && $game->status !== 'IN_PLAY');

        return [
            'day' => $matchday,
            'live' => $live,
            'completed' => $completed,
            'upcoming' => $upcoming
        ];

    }

    public function show(array $params): string
    {
        $day = (int)$this->competition()->current_matchday;
        
        if (!empty($params['id'])) {
            $day = (int)$params['id'];
        }

        return Views::render('matchday', $this->getMatchday($day));
    }
}
