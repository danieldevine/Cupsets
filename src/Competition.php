<?php

namespace Coderjerk\Cupsets;

use GuzzleHttp\Exception\GuzzleException;

class Competition
{
    public string $id;
    public string $name;
    public string $code;
    public string $type;
    public string $emblem;
    public object $standings;
    public object $season;
    public string $year;
    public string $start_date;
    public string $end_date;
    public ?string $current_matchday;
    public ?string $winner;

    /**
     * @throws GuzzleException
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->standings = $this->standings();
        $this->season = $this->standings->season;
        $this->year = $this->standings->filters->season;
        $this->start_date = $this->season->startDate;
        $this->end_date = $this->season->endDate;
        $this->current_matchday = $this->season->currentMatchday;
        $this->winner = $this->season->winner;
        $this->name = $this->standings->competition->name;
        $this->code = $this->standings->competition->code;
        $this->type = $this->standings->competition->type;
        $this->emblem = $this->standings->competition->emblem;
    }

    /**
     * @throws GuzzleException
     */
    public function teams()
    {
        return Http::getCompetitionData($this, 'teams');
    }

    /**
     * @throws GuzzleException
     */
    public function matches()
    {
        return Http::getCompetitionData($this, 'matches');
    }

    /**
     * @throws GuzzleException
     */
    public function standings()
    {
        return Http::getCompetitionData($this, 'standings');
    }

}
