(function() {
    var timeoutDuration = 60000; // 60 seconds
    var timer;

    function resetTimer() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            window.location.href = './index.php';
        }, timeoutDuration);
    }

    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.ontouchstart = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
})();
