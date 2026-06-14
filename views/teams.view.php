<x-head title="Teams"></x-head>

<h1>Teams</h1>

<section>
    <form method="post">
        <div class="team" :foreach="$data['teams']?->teams as $team">
            <img :src="$team->crest">
            <h3>{{ $team->name }}</h3>
            <label for="player-select">Choose Player</label>
            <select :name="$team->name">
                <option :foreach="$data['players'] as $player" :value="$player['player_id']">
                    {{ $player['player_name'] }}
                </option>
            </select>
        </div>
        <input type="submit">
    </form>
</section>
<x-foot></x-foot>
