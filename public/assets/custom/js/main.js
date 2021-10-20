$(document).ready(function () {

    setTimeout(function() {
        $('#flash-msg').fadeOut('fast');
    }, 5000)

    var table = $("#logs-table");
    // refresh every 10 seconds
    var refresher = setInterval(function() {
        table.load("/path/to/js.php");
    }, 10000);
});