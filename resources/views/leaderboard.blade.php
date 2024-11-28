<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leaderboard</title>
</head>
<body>
    <h1>Leaderboard</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Nickname</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scores as $index => $score)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $score->player->nickname }}</td>
                    <td>{{ $score->score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('game') }}">Back to Game</a>
</body>
</html>
