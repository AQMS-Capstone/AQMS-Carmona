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
                $('#status1').html("RECEIVING");
                $('#status1').attr("class","green-text");
            }else{
                $('#status1').html("DISCONNECTED");
                $('#status1').attr("class","red-text");
            }

            if(status2 == "1"){
                $('#status2').html("RECEIVING");
                $('#status2').attr("class","green-text");
            }else{
                $('#status2').html("DISCONNECTED");
                $('#status2').attr("class","red-text");
            }
        }
    });

    myGetFeed = setTimeout('GetBasics()', 1000);
}