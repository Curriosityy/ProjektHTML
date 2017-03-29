(function() {
    function leadingZero(i) {
        return (i < 10)? '0'+i : i;
    }

    function showTextTime() {
        var currentDate = new Date();
        var textTime = leadingZero(currentDate.getHours()) + ":" + leadingZero(currentDate.getMinutes()) + ":" + leadingZero(currentDate.getSeconds());

        document.querySelector('#fCzas').innerHTML = textTime;

        setTimeout(function() {
            showTextTime()
        }, 1000);
    }

    showTextTime();
})();
