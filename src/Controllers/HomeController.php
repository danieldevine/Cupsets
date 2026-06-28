<?php

namespace Coderjerk\Cupsets\Controllers;

use Coderjerk\Cupsets\Player;
use Coderjerk\Cupsets\Team;
use Coderjerk\Cupsets\Views;

class HomeController
{
    protected function getStandings(): array
    {
        $teams = self::updatedTeams();
        $players = self::updatedPlayers();

        return [
            'teams' => $teams,
            'players' => $players,
        ];
    }

    public static function updatedPlayers(): array
    {
        $players = Player::all();
        $updatedPlayers = [];

        foreach ($players as $player) {
            $updatedPlayers[] = Player::updatePlayerScore($player['player_id']);
        }

        return $updatedPlayers;
    }

    public static function updatedTeams(): array
    {
        $teams = Team::all();
        $updatedTeams = [];
        foreach ($teams as $team) {
            $updatedTeams[] = Team::updateTeamScores($team['team_id']);
        }
        return $updatedTeams;
    }

    public function show(): string
    {
        return Views::render('standings', ['standings' => $this->getStandings()]);
    }

}
