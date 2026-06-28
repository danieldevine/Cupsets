<?php

namespace Coderjerk\Cupsets\Controllers;

use Coderjerk\Cupsets\Competition;
use Coderjerk\Cupsets\Game;
use Coderjerk\Cupsets\Http;
use Coderjerk\Cupsets\Views;
use Coderjerk\Cupsets\Enums\Stage;

class KnockoutController
{
    public static function tournament()
    {
        $competition = new Competition('2000');
        return $competition->matches();
    }

    public static function getGamesByStage(Stage $stage): array
    {
        return array_filter(self::games(), fn($game) => $game->stage === $stage);
    }

    public static function games(): array
    {
        $games = [];

        foreach (self::tournament()->matches as $match) {
            $games[] = new Game($match);
        }

        return $games;
    }

    public static function getKnockoutGames(): array
    {
        return [
            'last_32' => self::getGamesByStage(Stage::LAST_32),
            'last_16' => self::getGamesByStage(Stage::LAST_16),
            'quarter_finals' => self::getGamesByStage(Stage::QUARTER_FINALS),
            'semi_finals' => self::getGamesByStage(Stage::SEMI_FINALS),
            'third_place' => self::getGamesByStage(Stage::THIRD_PLACE),
            'final' => self::getGamesByStage(Stage::FINAL),
        ];
    }

    public function show(array $params): string
    {
        return Views::render('knockouts', self::getKnockoutGames());
    }
}
