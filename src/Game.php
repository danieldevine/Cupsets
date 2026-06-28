<?php

namespace Coderjerk\Cupsets;

use DateTime;
use DateTimeZone;
use NumberFormatter;
use stdClass;
use Coderjerk\Cupsets\Enums\Stage;

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
    public DateTime $utcDate;
    public ?string $group;
    public Stage $stage;
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
        $this->group = $data->group;
        $this->stage = Stage::from($data->stage);
        $this->status = $data->status;
        $this->utcDate = $this->getLocalDate($data->utcDate);
    }

    public function getLocalDate($utcDate): DateTime
    {
        $date = new DateTime($utcDate);
        $date->setTimezone(new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone('GMT+1'));
        return $date;
    }

    public static function niceName($name): string
    {
        $format = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        if (!str_starts_with($name, 'Bot')) {
            return $name;
        }

        $parts = explode(' ', $name);
        $bot_number = (int)$parts[1];
        $nice_number = $format->format($bot_number);
        return $parts[0] . ' ' . ucfirst($nice_number);
    }
}
