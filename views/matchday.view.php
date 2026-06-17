<x-layout :title="'Match Day ' .  $data['day'] ?? ''">
    <section :if="!empty($data['live'])">
        <h2>Live</h2>
        <div class="games games--live">
            <x-games :games="$data['live']"></x-games>
        </div>
    </section>

    <section :if="!empty($data['upcoming'])">
        <h2>Fixtures</h2>
        <div class="games games--upcoming">
            <x-games :games="$data['upcoming']"></x-games>
        </div>
    </section>

    <section :if="!empty($data['completed'])">
        <h2>Results</h2>
        <div class="games games--results">
            <x-games :games="$data['completed']"></x-games>
        </div>
    </section>

    <section class="section--nav">
        <div :if="in_array($data['day'], [1, 2, 3])">
            <a href="/matchday/1">Group Stage Matchday 1</a> |
            <a href="/matchday/2">Group Stage Matchday 2</a> |
            <a href="/matchday/3">Group Stage Matchday 3</a>
        </div>
    </section>

</x-layout>
