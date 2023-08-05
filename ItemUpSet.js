function closeIframe() {
    // Close the iframe by removing it from the DOM
    window.parent.postMessage('closeIframe', '*');
}