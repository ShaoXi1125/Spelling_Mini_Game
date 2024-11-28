<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Spelling Mini Game</title>
</head>
<body>
    <form id='nicknameForm' method="POST">
        @csrf
        <label for="nickname">Enter Your Name: </label>
        <input type="text" id='nickname' name='nickname' required>
        <button type="submit">Start Game</button>
        <a href="{{ route('leaderboard') }}">View Leaderboard</a>

    </form>

    <div id="gameArea" style="display: none;">
        <p id='word'></p>
        <input type="text" id='answer'>
        <button id='submitAnswer'>Submit</button>
        <p>Time left: <span id='timeLeft'>60</span> seconds</p>
        <p>Score: <span id="score">0</span></p>
    </div>

    <script>
       const words = ["apple", "banana", "cherry", "grape", "orange", "lemon", "strawberry", "peach", "melon", "kiwi"];
       let userId, score = 0, timer = 60, currentWordIndex = 0, originalWord = '';

        function shuffleWords() {
            for (let i = words.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [words[i], words[j]] = [words[j], words[i]];
            }
        }

        function maskWord(word) {
            const letters = word.split('');
            let masked = letters.map(() => '_');

            const indicesToReveal = new Set();
            while (indicesToReveal.size < Math.min(3, letters.length)) {
                indicesToReveal.add(Math.floor(Math.random() * letters.length));
            }

            indicesToReveal.forEach((index) => {
                masked[index] = letters[index];
            });

            return masked.join('');
        }

        document.getElementById('nicknameForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const nickname = document.getElementById('nickname').value;

            const response = await fetch('/start-game', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ nickname })
            });

            const data = await response.json();
            userId = data.player.id;

            document.getElementById('nicknameForm').style.display = 'none';
            document.getElementById('gameArea').style.display = 'block';

            shuffleWords();
            startGame();
        });

        async function startGame() {
            const interval = setInterval(() => {
                timer--;
                document.getElementById('timeLeft').textContent = timer;

                if (timer <= 0) {
                    clearInterval(interval);
                    endGame();
                }
            }, 1000);

            showNextWord();
            document.getElementById('submitAnswer').addEventListener('click', checkAnswer);
        }

        function showNextWord() {
            if (currentWordIndex < words.length) {
                originalWord = words[currentWordIndex];
                const maskedWord = maskWord(originalWord);
                document.getElementById('word').textContent = maskedWord;
                document.getElementById('answer').value = '';
            } else {
                endGame();
            }
        }

        function checkAnswer() {
            const userAnswer = document.getElementById('answer').value.trim().toLowerCase();

            if (userAnswer === originalWord.toLowerCase()) {
                score++;
                document.getElementById('score').textContent = score;
            }

            currentWordIndex++;
            showNextWord();
        }

        async function endGame() {
            await fetch('/submit_score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ player_id: userId, score })
            });

            alert('Game over! Your score: ' + score);
            location.reload();
        }

    </script>
</body>
</html>