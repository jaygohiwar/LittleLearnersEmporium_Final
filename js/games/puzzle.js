// Sliding Puzzle Game
const slidingPuzzleGame = {
    pieces: ['🔴', '🟣', '🔵', '🟢', '🟡', '🟤', '⚫', '⚪'],
    currentPuzzle: [],
    emptyIndex: 8,
    moves: 0,
    
    initialize() {
        const gameContainer = document.getElementById('gameContainer');
        gameContainer.innerHTML = `
            <div class="puzzle-game">
                <div class="game-header">
                    <h2>Sliding Puzzle</h2>
                    <div class="moves">Moves: <span id="moves">0</span></div>
                </div>
                <div id="puzzle-board" class="puzzle-board"></div>
                <div class="game-controls">
                    <button id="reset-btn" class="game-btn">Restart Game</button>
                </div>
                <div class="game-instructions">
                    <p>Click on a piece next to the empty space to move it. Arrange all pieces in the correct order to win!</p>
                </div>
            </div>
        `;

        this.setupStyles();
        this.startGame();
        this.setupEventListeners();
    },

    setupStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .puzzle-game {
                padding: 20px;
                background: #f5f5f5;
                border-radius: 15px;
                max-width: 400px;
                margin: 0 auto;
                text-align: center;
            }

            .game-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                padding: 10px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }

            .moves {
                font-size: 1.2em;
                font-weight: bold;
                color: #4e342e;
            }

            .puzzle-board {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 5px;
                background: white;
                padding: 10px;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                margin-bottom: 20px;
            }

            .puzzle-piece {
                aspect-ratio: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5em;
                background: #fff;
                border: 2px solid #ddd;
                border-radius: 10px;
                cursor: pointer;
                transition: transform 0.2s, background-color 0.2s;
            }

            .puzzle-piece:not(.empty):hover {
                transform: scale(0.95);
                background-color: #f5f5f5;
            }

            .puzzle-piece.empty {
                border: 2px dashed #ddd;
                background: #f9f9f9;
            }

            .game-btn {
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                background: #4e342e;
                color: white;
                cursor: pointer;
                font-size: 1em;
                transition: background 0.3s;
            }

            .game-btn:hover {
                background: #3e2723;
            }

            .game-instructions {
                margin-top: 20px;
                color: #666;
                font-size: 0.9em;
            }

            .win-message {
                background: #4CAF50;
                color: white;
                padding: 20px;
                border-radius: 10px;
                margin-top: 20px;
                animation: fadeIn 0.5s ease-in;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    },

    startGame() {
        this.moves = 0;
        document.getElementById('moves').textContent = '0';
        this.currentPuzzle = [...this.pieces, ''];
        this.shufflePuzzle();
        this.renderPuzzle();
    },

    shufflePuzzle() {
        // Shuffle the puzzle ensuring it's solvable
        do {
            for (let i = this.currentPuzzle.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [this.currentPuzzle[i], this.currentPuzzle[j]] = 
                [this.currentPuzzle[j], this.currentPuzzle[i]];
            }
            this.emptyIndex = this.currentPuzzle.indexOf('');
        } while (!this.isSolvable() || this.isComplete());
    },

    isSolvable() {
        let inversions = 0;
        const puzzle = this.currentPuzzle.filter(piece => piece !== '');
        
        for (let i = 0; i < puzzle.length - 1; i++) {
            for (let j = i + 1; j < puzzle.length; j++) {
                if (puzzle[i] > puzzle[j]) inversions++;
            }
        }
        
        const emptyRowFromBottom = Math.floor((8 - this.emptyIndex) / 3);
        return (inversions + emptyRowFromBottom) % 2 === 0;
    },

    renderPuzzle() {
        const board = document.getElementById('puzzle-board');
        board.innerHTML = this.currentPuzzle.map((piece, index) => `
            <div class="puzzle-piece ${piece === '' ? 'empty' : ''}" data-index="${index}">
                ${piece}
            </div>
        `).join('');
    },

    setupEventListeners() {
        const board = document.getElementById('puzzle-board');
        const resetBtn = document.getElementById('reset-btn');

        board.addEventListener('click', (e) => {
            const piece = e.target.closest('.puzzle-piece');
            if (!piece) return;

            const index = parseInt(piece.dataset.index);
            if (this.isMovable(index)) {
                this.movePiece(index);
                this.moves++;
                document.getElementById('moves').textContent = this.moves;
                
                if (this.isComplete()) {
                    this.showWinMessage();
                }
            }
        });

        resetBtn.addEventListener('click', () => {
            this.startGame();
        });
    },

    isMovable(index) {
        const row = Math.floor(index / 3);
        const col = index % 3;
        const emptyRow = Math.floor(this.emptyIndex / 3);
        const emptyCol = this.emptyIndex % 3;

        return (Math.abs(row - emptyRow) === 1 && col === emptyCol) ||
               (Math.abs(col - emptyCol) === 1 && row === emptyRow);
    },

    movePiece(index) {
        [this.currentPuzzle[index], this.currentPuzzle[this.emptyIndex]] = 
        [this.currentPuzzle[this.emptyIndex], this.currentPuzzle[index]];
        this.emptyIndex = index;
        this.renderPuzzle();
    },

    isComplete() {
        // Check if all pieces are in their correct positions
        for (let i = 0; i < this.pieces.length; i++) {
            if (this.currentPuzzle[i] !== this.pieces[i]) {
                return false;
            }
        }
        return true;
    },

    showWinMessage() {
        const board = document.getElementById('puzzle-board');
        const existingWinMessage = document.querySelector('.win-message');
        if (existingWinMessage) {
            existingWinMessage.remove();
        }
        
        const winMessage = document.createElement('div');
        winMessage.className = 'win-message';
        winMessage.innerHTML = `
            <h2>Congratulations! 🎉</h2>
            <p>You solved the puzzle in ${this.moves} moves!</p>
            <button onclick="this.parentElement.remove()" class="game-btn">Close</button>
        `;
        board.insertAdjacentElement('afterend', winMessage);
    }
};

// Initialize the game when called from the main game launcher
function startPuzzle() {
    slidingPuzzleGame.initialize();
} 