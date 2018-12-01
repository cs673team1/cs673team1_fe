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

        // TODO: when this alert exits we revert to the php file as a web page ... ick ...
        if (!(title && desc)) {
            alert("Please fill in title and description");
        }
        if (!user) {
            alert("Please log in");
        }
        else {
            var postData = 'CardID=' + cardID + '&Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    $('#editCardForm .modal-header .modal-title').html("Result");
                    $('#editCardForm .modal-body').html(data);
                    $("#editCardSubmit").remove();
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
