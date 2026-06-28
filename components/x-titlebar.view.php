<div class="titlebar">
    <img :src="$app->competition->emblem" alt="">
    <h1>{{ $title }} :: {{ $app->competition->name }}{{ $app->competition->year }} </h1>
    <nav>
        <ul>
            <li>
                <a href="/">Standings</a>
            </li>
            <li>
                <a href="/leaderboard">Leaderboard</a>
            </li>
            <li>
                <a href="/games/">Games</a>
            </li>
        </ul>
    </nav>
</div>
