//VONN NOTE

//THINGS TO HASH:

// USERNAME AND PASSWORD!!

// GET CREATED_BY FIELD FROM SESSION!!!!!!!!!!!!
function saveAccount(userid, input1, input2, input3){
    var INPUT2 = input2.value;
    var INPUT3 = input3.value;

    if(input1 != "" && INPUT3 != ""){
        $.ajax
        ({
            type: 'POST',
            url: 'account_saver.php',
            data: {UID: userid, USERNAME: input1, PASSWORD: INPUT2, PRIVILEGE: INPUT3},
            success: function (response) {
                if (response == 'Success') {
                    document.location.reload();
                }

                else {
                    alert(response);
                }
            }
        });
    }else{
        alert("Try again.");
    }
}

$(document).ready(function () {
    $('#example').DataTable({
        'order': [[3, 'desc']],
        'columnDefs': [{'targets': '_all'}],
        stateSave: true
    });

    $('.modal-trigger').leanModal({});
});

$(document).on('click', function () {
    $('.modal-trigger').leanModal({});
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
        }else{
            $('#status1').html("DISCONNECTED");
            $('#status1').attr("class","red-text");
        }

        if(status2 == "1"){
            $('#status2').html("SENDING");
            $('#status2').attr("class","green-text");
        }else{
            $('#status2').html("DISCONNECTED");
            $('#status2').attr("class","red-text");
        }
    }
});
$(function()
{
    //
    myGetFeed = setTimeout('GetServerTime()', 1000);
});

function GetServerTime()
{
    $.ajax({
        type: "GET",
        url: 'retrieve_time.php',
        dataType: 'JSON',
        success: function (response) {
            var time = response["serverTime"];
            $('#serverTime').html(time);
        }
    });

}
