// Memory Game Implementation
function initMemoryGame() {
  const gameContainer = document.getElementById('gameContainer');
  const emojis = ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼'];
  const cards = [...emojis, ...emojis];
  let flippedCards = [];
  let matchedPairs = 0;

  // Shuffle cards
  const shuffledCards = cards.sort(() => Math.random() - 0.5);

  // Create game board
  const gameBoard = document.createElement('div');
  gameBoard.className = 'memory-game';
  gameBoard.innerHTML = shuffledCards.map((emoji, index) => `
    <div class="memory-card" data-card="${emoji}">
      <div class="memory-card-front">❓</div>
      <div class="memory-card-back">${emoji}</div>
    </div>
  `).join('');

  gameContainer.appendChild(gameBoard);

  // Add game controls
  const controls = document.createElement('div');
  controls.className = 'game-controls';
  controls.innerHTML = `
    <button class="restart-btn">Restart Game</button>
    <div class="score">Pairs Found: <span>0</span>/8</div>
  `;
  gameContainer.appendChild(controls);

  // Game logic
  const memoryCards = document.querySelectorAll('.memory-card');
  const scoreDisplay = document.querySelector('.score span');

  memoryCards.forEach(card => {
    card.addEventListener('click', () => {
      if (flippedCards.length < 2 && !card.classList.contains('flipped')) {
        flipCard(card);
      }
    });
  });

  function flipCard(card) {
    card.classList.add('flipped');
    flippedCards.push(card);

    if (flippedCards.length === 2) {
      const [card1, card2] = flippedCards;
      const emoji1 = card1.dataset.card;
      const emoji2 = card2.dataset.card;

      if (emoji1 === emoji2) {
        // Match found
        matchedPairs++;
        scoreDisplay.textContent = matchedPairs;
        flippedCards = [];

        if (matchedPairs === 8) {
          setTimeout(() => {
            alert('Congratulations! You won! 🎉');
          }, 500);
        }
      } else {
        // No match
        setTimeout(() => {
          card1.classList.remove('flipped');
          card2.classList.remove('flipped');
          flippedCards = [];
        }, 1000);
      }
    }
  }

  // Restart game
  document.querySelector('.restart-btn').addEventListener('click', () => {
    gameContainer.innerHTML = '';
    initMemoryGame();
  });

  // Add game instructions
  const instructions = document.createElement('div');
  instructions.className = 'game-instructions';
  instructions.innerHTML = `
    <h3>How to Play</h3>
    <p>Click on cards to flip them and find matching pairs. Try to find all pairs in the fewest moves!</p>
  `;
  gameContainer.insertBefore(instructions, gameBoard);
} 