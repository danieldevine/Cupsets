<div class="game" :foreach="$games as $game">
    <div class="game__crest">
        <img class="game__team-crest" :src="$game->homeTeam->crest"/>
        <span class="game__tla">{{ $game->homeTeam->tla }}</span>
    </div>

    <div>
        <h6> {{ $game->utcDate->format('ga :: l d M') }}</h6>
        <div :class="'game__details game__details--winner--' . $game->score?->winner">
            <span class="game__team-name game__team-name--home">{{ $game::niceName(\Coderjerk\Cupsets\Player::getPlayerByTeamName($game->homeTeam->name)) }}</span>
            <span class="game__score game__score--home">{{ $game->score?->fullTime->home }}</span>
            <span :if="!$game->score?->winner" class="versus">v</span>
            <span :else>-</span>
            <span class="game__score game__score--away">{{ $game->score?->fullTime->away }}</span>
            <span class="game__team-name game__team-name--away">{{ $game::niceName(\Coderjerk\Cupsets\Player::getPlayerByTeamName($game->awayTeam->name)) }}</span>
        </div>
    </div>

    <div class="game__crest">
        <img class="game__team-crest" :src="$game->awayTeam->crest"/>
        <span class="game__tla">{{ $game->awayTeam->tla }}</span>
    </div>
</div>
