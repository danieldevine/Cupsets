<?php

namespace Coderjerk\Cupsets;

use stdClass;

class Game
{
    public stdClass $area;
    public stdClass $awayTeam;
    public stdClass $competition;
    public stdClass $homeTeam;
    public stdClass $odds;
    public array $referees;
    public stdClass $score;
    public stdClass $season;
    public int $id;
    public ?int $matchday;
    public ?string $utcDate;
    public ?string $group;
    public string $stage;
    public string $status;

    public function __construct($data)
    {
        $this->area = $data->area;
        $this->awayTeam = $data->awayTeam;
        $this->competition = $data->competition;
        $this->homeTeam = $data->homeTeam;
        $this->odds = $data->odds;
        $this->referees = $data->referees;
        $this->score = $data->score;
        $this->season = $data->season;
        $this->id = $data->id;
        $this->matchday = $data->matchday;
        $this->utcDate = $data->utcDate;
        $this->group = $data->group;
        $this->stage = $data->stage;
        $this->status = $data->status;
    }

}
