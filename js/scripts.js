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

function displayActivity(activityIsset, activityGet) {
    //image ajax call
    var imageData = '';
    $.ajax({
        type: "GET",
        data: {
            "activityDisplay": $('#activityDisplay').val()
        },
        url: "http://localhost/AdvWebFinal/webservice.php?infoType=image",
        dataType: "json",
        success: function (JSONObject) {
            var activityHTML = "";


            //loop through object
            for(var key in JSONObject) {
                if (JSONObject.hasOwnProperty(key)) {

                    if (activityIsset){
                        if (JSONObject[key]["id"] == activityGet) {
                            imageData = '<img src="' + JSONObject[key]["filePath"] + '" alt="' + JSONObject[key]["altText"] + '"/>';
                        }
                    }
                }
            }
        }
    });

    //activity ajax call
    $.ajax({
        type: "GET",
        data: {
            "activityDisplay": $('#activityDisplay').val()
        },
        url: "http://localhost/AdvWebFinal/webservice.php?infoType=activity",
        dataType: "json",
        success: function (JSONObject) {
            var activityHTML = "";


            //loop through object
            for(var key in JSONObject) {
                if (JSONObject.hasOwnProperty(key)) {

                    if (activityIsset){
                        if (JSONObject[key]["id"] == activityGet) {
                            //activityHTML += '<p>' + JSONObject[key]["name"] + '</p>';
                            activityHTML += '<div class="activity-box">';
                            activityHTML += '<h2>' + JSONObject[key]["name"] + '</h2>';
                            activityHTML += imageData; //image
                            // activityHTML += $(function () {
                            //     return getImages('http://localhost/AdvWebFinal/webservice.php?infoType=image', activityGet);
                            // });
                            activityHTML += '<h3 style="background-color: white">Location: ' + JSONObject[key]["street"] + ', ' + JSONObject[key]["city"] + ', ' + JSONObject[key]["state"] + ', ' + JSONObject[key]["postal"] + '</h3>';
                            activityHTML += '<p style="background: white">' + JSONObject[key]["description"] + '</p>';
                            activityHTML += ''; //session button
                            activityHTML += '</div>';
                        }
                    }
                }
            }

            //insert activity into html
            $('#activityDisplay').html(activityHTML);
        }
    });
}

function getImages(url, activityID) {
    let imageData = '';
    $.ajax({
        type: "GET",
        data: {
            "activityDisplay": $('#activityDisplay').val()
        },
        url: url,
        dataType: "json",
        success: function (JSONObject) {


            //loop through object
            for(var key in JSONObject) {
                if (JSONObject.hasOwnProperty(key)) {

                    if (JSONObject[key]["id"] === activityID) {
                        imageData = '<img src="' + JSONObject[key]["filePath"] + '" alt="' + JSONObject[key]["altText"] + '"/>';
                    }

                }
            }
        }
    });

    return imageData;

}

function loadActivities() {

}

//2d array sort function
function sortFunction(a, b) {
    if (a[0] === b[0]) {
        return 0;
    }
    else {
        return (a[0] < b[0]) ? -1 : 1;
    }
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





