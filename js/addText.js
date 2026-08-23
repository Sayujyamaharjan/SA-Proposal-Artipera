export function AddText(selector, text) {
    let el = document.querySelector(selector);
    if (el) {
        el.innerText = `${text}`;
    }
}
