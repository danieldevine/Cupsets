<x-layout title="Leaderboard">
    <section>
        <h2>Dillon World League Champion*</h2>
        <small>Current Leaders</small>
        <table class="leaderboard-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Player</th>
                <th>Points</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="table__position">
                    1
                </td>
                <td class="table__player">
                    {{ $data['league_champion']['gold']['player_name'] }}
                </td>
                <td class="table__player">
                    {{ $data['league_champion']['gold']['player_points'] }}
                </td>
            </tr>
            <tr>
                <td class="table__position">
                    2
                </td>
                <td class="table__player">
                    {{ $data['league_champion']['silver']['player_name'] }}
                </td>
                <td class="table__player">
                    {{ $data['league_champion']['silver']['player_points'] }}
                </td>
            </tr>
            <tr>
                <td class="table__position">
                    3
                </td>
                <td class="table__player">
                    {{ $data['league_champion']['bronze']['player_name'] }}
                </td>
                <td class="table__player">
                    {{ $data['league_champion']['bronze']['player_points'] }}
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    <section>
        <h2>Toto Schillaci Golden Boot/Gary Breen Silver Boot**</h2>
        <small>Current Leaders</small>

        <table class="leaderboard-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Player</th>
                <th>Goals</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="table__position">
                    1
                </td>
                <td class="table__player">
                    {{ implode(', ' , array_keys($data['golden_boot']['gold'])) }}
                </td>
                <td class="table__player">
                    {{ array_values($data['golden_boot']['gold'])[0] }}
                </td>
            </tr>
            <tr>
                <td class="table__position">
                    2
                </td>
                <td class="table__player">
                    {{ implode(', ' , array_keys($data['golden_boot']['silver'])) }}
                </td>
                <td class="table__player">
                    {{ array_values($data['golden_boot']['silver'])[0] }}
                </td>
            </tr>
            <tr>
                <td class="table__position">
                    3
                </td>
                <td class="table__player">
                    {{ implode(', ' , array_keys($data['golden_boot']['bronze'])) }}
                </td>
                <td class="table__player">
                    {{ array_values($data['golden_boot']['bronze'])[0] }}
                </td>
            </tr>
            </tbody>
        </table>
    </section>
    <section>
        <h2>Stephen Kenny Moral Victory World Champion***</h2>
        <small>Current Leaders</small>
        <table class="leaderboard-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Player</th>
                <th>MVQ</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="table__position">
                    1
                </td>
                <td class="table__player">
                    {{ implode(', ' , array_keys($data['moral_victor']['gold'])) }}
                </td>
                <td class="table__player">
                    {{ array_values($data['moral_victor']['gold'])[0] }}
                </td>
            </tr>
            <tr>
                <td class="table__position">
                    2
                </td>
                <td class="table__player">
                    {{ implode(', ' , array_keys($data['moral_victor']['silver'])) }}
                </td>
                <td class="table__player">
                    {{ array_values($data['moral_victor']['silver'])[0] }}
                </td>
            </tr>
            <tr>
                <td class="table__position">
                    3
                </td>
                <td class="table__player">
                    {{ implode(', ' , array_keys($data['moral_victor']['bronze'])) }}
                </td>
                <td class="table__player">
                    {{ array_values($data['moral_victor']['bronze'])[0] }}
                </td>
            </tr>
            </tbody>
        </table>
        <p>* Not to be confused with the Dillon World Cup Champion</p>
        <p>** Gary Breen is still Ireland's joint all-time second-highest goalscorer in the World Cup.</p>
        <p>*** Top three in the real league table excluded. You can take a lot of positives from the performance.</p>
    </section>
</x-layout>
