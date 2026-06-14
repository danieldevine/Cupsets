<x-layout :title="$data['day'] ?? ''">
    <h1> Match Day {{ $data['day'] ?? '' }}</h1>
    <section :if="!empty($data['live'])">
        <h2>Live</h2>
        <div class="games game--live">
            <div class="game" :foreach="$data['live'] as $game">
                <img :src="$game->homeTeam->crest"/>
                <span>{{ $game->homeTeam->name }} {{ $game->score?->fullTime->home}} v
                    {{ $game->score?->fullTime->away }} {{ $game->awayTeam->name }}</span>
                <img :src="$game->awayTeam->crest"/>
            </div>
        </div>
    </section>
    <section :if="!empty($data['completed'])">
        <h2>Results</h2>
        <div class="games">
            <div class="game" :foreach="$data['completed'] as $game">
                <img :src="$game->homeTeam->crest"/>
                <span>{{ $game->homeTeam->name }} {{ $game->score?->fullTime->home}} v
               {{ $game->score?->fullTime->away }} {{ $game->awayTeam->name }}</span>
                <img :src="$game->awayTeam->crest"/>
            </div>
        </div>
    </section>
    <section>
        <h2>Upcoming</h2>
        <div class="games games--upcoming">
            <div class="game" :foreach="$data['upcoming'] as $game">
                <img :src="$game->homeTeam->crest"/>
                <span>{{ $game->homeTeam->name }} {{ $game->score?->fullTime->home}} v
                 {{ $game->score?->fullTime->away }} {{ $game->awayTeam->name }}</span>
                <img :src="$game->awayTeam->crest"/>
            </div>
        </div>
    </section>
</x-layout>
