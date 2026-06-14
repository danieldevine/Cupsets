<?php

namespace Coderjerk\Cupsets\Controllers;

use Coderjerk\Cupsets\Competition;
use Coderjerk\Cupsets\Http;
use Coderjerk\Cupsets\Player;
use Coderjerk\Cupsets\Team;
use Coderjerk\Cupsets\Views;
use GuzzleHttp\Exception\GuzzleException;

class TeamController
{
    /**
     * @throws GuzzleException
     */
    public function teams(string $competition_id)
    {
        $competition = new Competition($competition_id);

        return Http::getCompetitionData($competition, 'teams');
    }

    protected function players(): ?array
    {
        return Player::all();
    }

    public function create(): void
    {
        $request = $_POST;

        foreach ($request as $team_name => $player_id) {
            $team = new Team();
            $team->create($team_name, $player_id);
        }
    }

    /**
     * @throws GuzzleException
     */
    public function show(array $params): string
    {
        $competition_id = $params['id'];
        return Views::render('teams', [
            'teams' => $this->teams($competition_id),
            'players' => $this->players()
        ]);
    }
}
