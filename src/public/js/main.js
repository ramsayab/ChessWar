/* ═══════════════════════════════════════
   Chess War — Main JavaScript
   ═══════════════════════════════════════ */

/**
 * Build a checkerboard decoration grid inside a container element.
 * @param {HTMLElement} el - The container element
 */
function buildBoard(el) {
  if (!el) return;
  el.innerHTML = '';
  for (let r = 0; r < 8; r++) {
    for (let c = 0; c < 8; c++) {
      const sq = document.createElement('div');
      sq.className = 'sq' + ((r + c) % 2 !== 0 ? ' sq-dark' : '');
      el.appendChild(sq);
    }
  }
}

// Init all board decorations on the page
document.querySelectorAll('.board-deco, .auth-board').forEach(buildBoard);
