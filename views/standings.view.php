<x-layout title="Standings">
    <section>
        <table>
            <thead>
            <tr>
                <th>
                    Position
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
                <td class="position">{{ $count + 1 }}</td>
                <td>
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
