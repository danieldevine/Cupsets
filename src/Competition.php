<?php

namespace Coderjerk\Cupsets;

use GuzzleHttp\Exception\GuzzleException;

class Competition
{
    public string $id;
    public string $name;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @throws GuzzleException
     */
    protected function getTeams()
    {
        return Http::getCompetitionData($this, 'teams');
    }

    /**
     * @throws GuzzleException
     */
    protected function getMatches()
    {
        return Http::getCompetitionData($this, 'matches');
    }

    /**
     * @throws GuzzleException
     */
    protected function getStandings()
    {
        return Http::getCompetitionData($this, 'standings');
    }

    public function teams()
    {
        return $this->getTeams();
    }

    public function matches()
    {
        return $this->getMatches();
    }

    public function standings()
    {
        return $this->getStandings();
    }
}
