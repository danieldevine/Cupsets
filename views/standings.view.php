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
                    Total Points
                </th>
                <th>
                    Goal Difference
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
                    {{ $player['player_points'] }}
                </td>
                <td>
                    {{ $player['player_goal_difference'] }}
                </td>
                <td>
                    {{ Coderjerk\Cupsets\Player::playerTeamNames($player['player_id']) }}
                </td>
                <td>
                    {{ $player['player_id'] }}
                </td>
                <td>{{ sprintf("%+d", $player['player_id'] - ($count + 1)) }}</td>
                <?php
                $count++ ?>
            </tr>
            </tbody>
        </table>
        <p>3 points for a win, 1 point for a draw,league position determined by 1.points, 2.goal difference and
            3.reverse of original picking order. Not officially affiliated with FIFA or Dillon family sweepstake. </p>
        <p>* MVQ = Moral Victory Quotient - position over/under original pick</p>
    </section>


</x-layout>
