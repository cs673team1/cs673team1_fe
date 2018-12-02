// editCard java script, invoked from editCard modal ...
$(document).ready(function () {
    function dataValid() {
        var title = $("#editCardTitle").val();
        var desc = $("#editCardDesc").val();
        var user = document.getElementById("user-list").value;

        if (!user || user.toString().match(/login/i)) {
            document.getElementById("editCardError").hidden = '';
            document.getElementById("editCardError").innerHTML = "Please log in";
            $("#editCardModal").reload(true);
            return false;
        }
        else if (!(title && desc)) {
            document.getElementById("editCardError").hidden = '';
            document.getElementById("editCardError").innerHTML = "Please fill in title and description";
            $("#editCardModal").reload(true);
            return false;
        }

        return true;
    }

    $("#editCardForm").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var cardID = $("#editCardID").val();
        var title = $("#editCardTitle").val();
        var owner = $("#editCardOwner").val();
        var desc = $("#editCardDesc").val();
        var status = document.querySelector('input[name=editCardStatusBtnGrp]:checked').value;
        var user = document.getElementById("user-list").value;

        var postData = 'CardID=' + cardID + '&Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
                //$('#editCardForm .modal-header .modal-title').html("Edited card");
                //$('#editCardForm .modal-body').html(data);
                //$("#editCardSubmit").remove(); ... NO, hides the button!
                // do not reset data ... maybe user wants to keep on editing
                //location.reload(true);
            },
            error: function (jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });

    function hideModal() {
        $("#editCardModal").hide();
        $('.modal-backdrop').hide();
    }

    $("#editCardSubmit").on('click', function() {
        if (dataValid()) {
            $("#editCardForm").submit();
            hideModal();
        }
    });
});
