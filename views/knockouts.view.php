<x-layout title="Knockout Rounds">
    <section>
        <h2>Last 32</h2>
        <div class="games games--last-32">
            <x-games :games="$data['last_32']"></x-games>
        </div>
    </section>
    <section>
        <h2>Last 16</h2>
        <div class="games games--last-16">
            <x-games :games="$data['last_16']"></x-games>
        </div>
    </section>
    <section>
        <h2>Quarter Finals</h2>
        <div class="games games--quarter-finals">
            <x-games :games="$data['quarter_finals']"></x-games>
        </div>
    </section>
    <section>
        <h2>Semi Finals</h2>
        <div class="games games--semi-finals">
            <x-games :games="$data['semi_finals']"></x-games>
        </div>
    </section>
    <section>
        <h2>Third Place Playoff</h2>
        <div class="games games--third-place">
            <x-games :games="$data['third_place']"></x-games>
        </div>
    </section>
    <section>
        <h2>Final</h2>
        <div class="games games--final">
            <x-games :games="$data['final']"></x-games>
        </div>
    </section>
    <section class="section--nav">
        <div>
            <a href="/matchday/1">Group Stage Matchday 1</a> |
            <a href="/matchday/2">Group Stage Matchday 2</a> |
            <a href="/matchday/3">Group Stage Matchday 3</a>
        </div>
    </section>
</x-layout>
