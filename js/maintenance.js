/**
 * Created by Nostos on 18/02/2017.
 */

$(function()
{
    GetBasics();
});

function GetBasics() {
    $.ajax({
        type: "GET",
        url: 'retrieve_time.php',
        dataType: 'JSON',
        success: function (response) {
            var time = response["serverTime"];
            $('#serverTime').html(time);
        }
    });

    $.ajax({
        type: "GET",
        url: 'retrieve_device_status.php',
        dataType: 'JSON',
        success: function (response) {
            var status1 = response["status1"];
            var status2 = response["status2"];

            if(status1 == "1"){
                $('#status1').html("SENDING");
                $('#status1').attr("class","green-text");
                $('#message1').html("The municipality is receiving data from the BANCAL station. Click to disconnect from the BANCAL station.");
                $('#aqiColor1').attr("style", "margin-bottom: 15px; background: green;");
                $('#aqiText1').html("SENDING");
                $('#btn1').html("DISCONNECT");
            }else{
                $('#status1').html("DISCONNECTED");
                $('#status1').attr("class","red-text");
                $('#message1').html("The municipality is disconnected from the BANCAL station. Click to connect with the BANCAL station.");
                $('#aqiColor1').attr("style", "margin-bottom: 15px; background: red;");
                $('#aqiText1').html("DISCONNECTED");
                $('#btn1').html("CONNECT");
            }

            if(status2 == "1"){
                $('#status2').html("SENDING");
                $('#status2').attr("class","green-text");
                $('#message2').html("The municipality is receiving data from the SLEX station. Click to disconnect from the SLEX station.");
                $('#aqiColor2').attr("style", "margin-bottom: 15px; background: green;");
                $('#aqiText2').html("SENDING");
                $('#btn2').html("DISCONNECT");
            }else{
                $('#status2').html("DISCONNECTED");
                $('#status2').attr("class","red-text");
                $('#message2').html("The municipality is disconnected from the SLEX station. Click to connect with the SLEX station.");
                $('#aqiColor2').attr("style", "margin-bottom: 15px; background: red;");
                $('#aqiText2').html("DISCONNECTED");
                $('#btn2').html("CONNECT");
            }
        }
    });

    myGetFeed = setTimeout('GetBasics()', 1000);
}

function ChangeStat(cond){

    if(cond == "1"){
        var value = $("#aqiText1").text();

        if(value == "SENDING"){
            $.ajax({
                type: "GET",
                url: 'change_status.php',
                data: {phpValue: "1", phpValue2: "0"},
                success: function (response) {
                }
            });
        }else if(value == "DISCONNECTED"){
            $.ajax({
                type: "GET",
                url: 'change_status.php',
                data: {phpValue: "1", phpValue2: "1"},
                success: function (response) {
                }
            });
        }

    }else if(cond == "2"){
        var value = $("#aqiText2").text();

        if(value == "SENDING"){
            $.ajax({
                type: "GET",
                url: 'change_status.php',
                data: {phpValue: "2", phpValue2: "0"},
                success: function (response) {
                }
            });
        }else if(value == "DISCONNECTED"){
            $.ajax({
                type: "GET",
                url: 'change_status.php',
                data: {phpValue: "2", phpValue2: "1"},
                success: function (response) {
                }
            });
        }
    }
}