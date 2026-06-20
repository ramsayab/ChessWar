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

// Google Login Popup
const googleBtn = document.getElementById('google-login-btn');
if (googleBtn) {
  googleBtn.addEventListener('click', function(e) {
    e.preventDefault();
    const width = 500;
    const height = 650;
    const left = (screen.width / 2) - (width / 2);
    const top = (screen.height / 2) - (height / 2);
    window.open(this.href, 'GoogleLogin', `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,status=no`);
  });
}
