/* ═══════════════════════════════════════
   Chess War — Dashboard JavaScript
   ═══════════════════════════════════════ */

/**
 * Build the mini chess board preview with highlighted squares.
 */
function buildMiniBoard() {
  const board = document.getElementById('miniBoard');
  if (!board) return;
  board.innerHTML = '';

  const highlights = [18, 27, 36, 45]; // diagonal highlight

  for (let i = 0; i < 64; i++) {
    const sq = document.createElement('div');
    const row = Math.floor(i / 8);
    const col = i % 8;

    if (highlights.includes(i)) {
      sq.className = 'mini-sq highlight';
    } else {
      sq.className = 'mini-sq ' + ((row + col) % 2 === 0 ? 'light' : 'dark-sq');
    }

    board.appendChild(sq);
  }
}

/**
 * Build the weekly activity bar chart.
 * @param {number[]} values - Array of 7 percentage values (0–100)
 */
function buildActivityChart(values = [40, 65, 50, 80, 35, 90, 55]) {
  const chart = document.getElementById('activityChart');
  if (!chart) return;
  chart.innerHTML = '';

  values.forEach(v => {
    const bar = document.createElement('div');
    bar.className = 'bar';
    bar.style.height = v + '%';
    bar.title = v + ' games';
    chart.appendChild(bar);
  });
}

/**
 * Handle dashboard nav item clicks.
 */
document.querySelectorAll('.dash-nav-item').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.dash-nav-item').forEach(i => i.classList.remove('active'));
    item.classList.add('active');
  });
});

/**
 * Handle sidebar item clicks.
 */
document.querySelectorAll('.sidebar-item').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
    item.classList.add('active');
  });
});

// Init on load
document.addEventListener('DOMContentLoaded', () => {
  buildMiniBoard();
  buildActivityChart();
});
