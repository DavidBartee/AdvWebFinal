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





//display activities drop down (with no async)
/*
$(function () {
    //$("#webServDrop").on("change", displayWebServActivities);
    displayWebServActivities();
    function displayWebServActivities() {


        var url = "http://localhost/IST240/AdvWebFinal/webservice.php?infoType=activity";

        $.get(url)
            .done(function (data) {

                for (let i=0; i<data.length; i++){

                    var activity = data[i];

                    var option = $('<a href="midterm.php?activity=' + activity.id + '">' + activity.name + '</a>');
                    $("#webServerDropDown").append(option);
                }
            })
            .fail(function (jqXHR) {
                alert("Error: " + jqXHR.status);
            });


    }
});
 */

//activities drop down
$(function () {

    $('#ourTeamActivityBtn').hover(function() {
        $.ajax({
            type: "GET",
            data: {
                "ourWebServerDropDown": $('#ourWebServerDropDown').val()
            },
            url: "http://localhost/AdvWebFinal/webservice.php?infoType=activity",
            dataType: "json",
            success: function (JSONObject) {
                var activityHTML = "";


                //loop through object
                for(var key in JSONObject) {
                    if (JSONObject.hasOwnProperty(key)) {
                        activityHTML += '<a href="midterm.php?activity=';

                        activityHTML += JSONObject[key]["id"] + '">';
                        activityHTML += JSONObject[key]["name"] + '</a>';
                    }
                }

                //insert activity into html
                $('#webServerDropDown').html(activityHTML);
            }
        });
    });
});


//other web server drop down
$(function () {

    $('#otherTeamActivityBtn').hover(function() {
        $.ajax({
            type: "GET",
            data: {
                "otherWebServerDropDown": $('#otherWebServerDropDown').val()
            },
            //url: "http://localhost/AdvWebFinal/webservice.php?infoType=activity",
            dataType: "json",
            success: function (JSONObject) {
                var activityHTML = '';

                //loop through object
                for(var key in JSONObject) {
                    if (JSONObject.hasOwnProperty(key)) {
                        activityHTML += '<a href="midterm.php?activity=';
                        activityHTML += JSONObject[key]["id"] + '">';
                        activityHTML += JSONObject[key]["name"] + '</a>';
                    }
                }

                //insert activity into html
                $('#otherWebServerDropDown').html(activityHTML);
            }
        });
    });
});


//activities display





