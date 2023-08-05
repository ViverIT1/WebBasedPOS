<button onclick="closeIframe()">Close Iframe</button>
    function closeIframe() {
        // Get a reference to the parent window
        var parentWindow = window.parent;
        
        // Set the display property of the iframe's parent container to 'none'
        var iframeContainer = parentWindow.document.getElementById("updatepop");
        document.getElementById("updatepop").style.display = "none";
    }