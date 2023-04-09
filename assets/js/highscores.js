const highScoresList = document.getElementById('highScoresList');
const localStorageScores = localStorage.getItem("highScores");
const highScores = JSON.parse(localStorageScores) || [];

if (localStorageScores === null) {
  highScoresList.innerHTML = '<li class="high-score">No high scores to show.</li>';
} else {
  highScoresList.innerHTML = highScores.map(score => {
    return `<li class="high-score">${score.name} - ${score.score}</li>`;
  }).join("");
}