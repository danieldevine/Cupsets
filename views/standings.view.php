<x-layout title="League Table (Unofficial) ">
    <section>
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
                <?php
                $count++ ?>
            </tr>
            </tbody>
        </table>
    </section>

</x-layout>
