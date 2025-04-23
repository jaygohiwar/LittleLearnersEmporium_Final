// Counting Game Implementation
function initCountingGame() {
  const gameContainer = document.getElementById('gameContainer');
  let currentNumber = 0;
  let score = 0;
  let gameActive = true;

  // Create game interface
  const gameInterface = document.createElement('div');
  gameInterface.className = 'counting-game';
  gameInterface.innerHTML = `
    <div class="counting-number">${currentNumber}</div>
    <div class="counting-buttons">
      <button class="counting-btn" data-action="decrease">-</button>
      <button class="counting-btn" data-action="increase">+</button>
    </div>
    <div class="game-info">
      <div class="score">Score: <span>0</span></div>
      <div class="target">Target: <span>10</span></div>
    </div>
  `;

  gameContainer.appendChild(gameInterface);

  // Add game instructions
  const instructions = document.createElement('div');
  instructions.className = 'game-instructions';
  instructions.innerHTML = `
    <h3>How to Play</h3>
    <p>Count the objects and click the + or - buttons to match the target number!</p>
  `;
  gameContainer.insertBefore(instructions, gameInterface);

  // Game elements
  const numberDisplay = document.querySelector('.counting-number');
  const scoreDisplay = document.querySelector('.score span');
  const targetDisplay = document.querySelector('.target span');
  const buttons = document.querySelectorAll('.counting-btn');

  // Generate random target
  function generateTarget() {
    return Math.floor(Math.random() * 10) + 1;
  }

  let targetNumber = generateTarget();
  targetDisplay.textContent = targetNumber;

  // Update number display
  function updateNumber() {
    numberDisplay.textContent = currentNumber;
    if (currentNumber === targetNumber) {
      numberDisplay.style.color = '#4CAF50';
    } else {
      numberDisplay.style.color = '#333';
    }
  }

  // Check if target is reached
  function checkTarget() {
    if (currentNumber === targetNumber && gameActive) {
      score++;
      scoreDisplay.textContent = score;
      gameActive = false;

      // Show success message
      const successMessage = document.createElement('div');
      successMessage.className = 'success-message';
      successMessage.innerHTML = `
        <p>Great job! You counted to ${targetNumber}! 🎉</p>
        <button class="next-level">Next Level</button>
      `;
      gameContainer.appendChild(successMessage);

      // Next level button
      document.querySelector('.next-level').addEventListener('click', () => {
        gameContainer.removeChild(successMessage);
        startNewLevel();
      });
    }
  }

  // Start new level
  function startNewLevel() {
    currentNumber = 0;
    targetNumber = generateTarget();
    targetDisplay.textContent = targetNumber;
    gameActive = true;
    updateNumber();
  }

  // Button click handlers
  buttons.forEach(button => {
    button.addEventListener('click', () => {
      if (!gameActive) return;

      const action = button.dataset.action;
      if (action === 'increase' && currentNumber < 10) {
        currentNumber++;
      } else if (action === 'decrease' && currentNumber > 0) {
        currentNumber--;
      }

      updateNumber();
      checkTarget();
    });
  });

  // Add keyboard controls
  document.addEventListener('keydown', (e) => {
    if (!gameActive) return;

    if (e.key === 'ArrowUp' && currentNumber < 10) {
      currentNumber++;
      updateNumber();
      checkTarget();
    } else if (e.key === 'ArrowDown' && currentNumber > 0) {
      currentNumber--;
      updateNumber();
      checkTarget();
    }
  });

  // Add visual feedback
  buttons.forEach(button => {
    button.addEventListener('mousedown', () => {
      button.style.transform = 'scale(0.95)';
    });
    button.addEventListener('mouseup', () => {
      button.style.transform = 'scale(1)';
    });
    button.addEventListener('mouseleave', () => {
      button.style.transform = 'scale(1)';
    });
  });

  // Initialize the game
  updateNumber();
} 