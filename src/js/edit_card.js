// editCard java script, invoked from editCard modal ...
$(document).ready(function () {
    $("#editCardForm").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var cardID = $("#editCardID").val();
        var title = $("#editCardTitle").val();
        var owner = $("#editCardOwner").val();
        var desc = $("#editCardDesc").val();
        var status = document.querySelector('input[name=editCardStatusBtnGrp]:checked').value;
        var user = document.getElementById("user-list").value;

        if (!user || user.toString().match(/login/i)) {
            alert("Please log in");
            location.reload(true);
        }
        else if (!(title && desc)) {
            alert("Please fill in title and description");
            location.reload(true);
        }
        else {
            var postData = 'CardID=' + cardID + '&Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    $('#editCardForm .modal-header .modal-title').html("Edited card");
                    $('#editCardForm .modal-body').html(data);
                    $("#editCardSubmit").remove();
                    // do not reset data ... maybe user wants to keep on editing
                    location.reload(true);
                },
                error: function (jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        }
    });

    $("#editCardSubmit").on('click', function() {
        $("#editCardForm").submit();
    });
});
