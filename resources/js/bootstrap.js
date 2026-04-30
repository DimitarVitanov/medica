// Minimal CSRF-aware fetch wrapper (replaces axios, saves ~15KB)
window.axios = {
    defaults: { headers: { common: { 'X-Requested-With': 'XMLHttpRequest' } } },
    get: (url, config = {}) => fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', ...config.headers } }).then(r => r.json()),
    post: (url, data, config = {}) => fetch(url, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content, ...config.headers },
        body: JSON.stringify(data),
    }).then(r => r.json()),
};
