<x-layout title="League Table (Unofficial) ">
    <section class="section--standings">
        <table>
            <thead>
            <tr>
                <th>
                    #
                </th>
                <th>
                    Player
                </th>
                <th>
                    Games Played
                </th>
                <th>
                    Total Points
                </th>
                <th>
                    Goal Difference
                </th>
                <th>
                    Goals Scored
                </th>
                <th>
                    Form
                </th>
                <th>
                    Teams
                </th>
                <th>
                    Original Pick
                </th>
                <th>
                    MVQ*
                </th>
                <th>
                    Batting Average**
                </th>
            </tr>
            </thead>
            <tbody>
            <?php
            $count = 0 ?>
            <tr :foreach="$data['standings']['players'] as $player">
                <td class="table__position">{{ $count + 1 }}</td>
                <td class="table__player">
                    {{ $player['player_name'] }}
                </td>
                <td>
                    {{ $player['games_played'] }}
                </td>
                <td>
                    {{ $player['player_points'] }}
                </td>
                <td>
                    {{ $player['player_goal_difference'] }}
                </td>
                <td> {{ $player['player_goals_scored'] }}</td>

                <td>
                    {{ $player['form'] }}
                </td>
                <td>
                    {{ Coderjerk\Cupsets\Player::playerTeamNames($player['player_id']) }}
                </td>
                <td>
                    {{ $player['player_id'] }}
                </td>
                <td>{{ sprintf("%+d", $player['player_id'] - ($count + 1)) }}</td>
                <td>{{ round($player['batting_average'], 5) }}</td>
                <?php
                $count++ ?>
            </tr>
            </tbody>
        </table>

    </section>
    <section>
        <p>3 points for a win, 1 point for a draw, league position determined by (1.) points, (2.) goal difference and
            (3.) reverse of original picking order. Not officially affiliated with FIFA or Dillon family
            sweepstake. </p>
        <p>* MVQ = Moral Victory Quotient - position over/under original pick.</p>
        <p>** Batting Average = goals scored/games played.</p>
    </section>
</x-layout>
