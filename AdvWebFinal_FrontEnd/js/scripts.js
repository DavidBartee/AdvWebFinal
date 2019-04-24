var interval = null;

function resizeActivityBox () {
    $("div.activity-box").width($("div.activity-box img").width());
}

function enlargeSidebar () {
    if (!$(".activity-box").length && !$(".activity-box-small").length && !$(".notfound").length) {
        $(".sidebar").css ("font-size", "1.5em");
        $("div.sidebar").width("100%");
        $("div.sidebar").height("auto");
        clearInterval(interval);
    }
}

function sortActivities() {

}

function filterActivities() {

}

$(document).ready(function() {
    interval = setInterval(enlargeSidebar, 50);
});