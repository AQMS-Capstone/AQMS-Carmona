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