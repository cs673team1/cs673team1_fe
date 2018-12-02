// newBug java script, invoked from newBug modal ...
function dataValid() {
    var title = $("#newBugTitle").val();
    var desc = $("#newBugDesc").val();
    var user = document.getElementById("user-list").value;

    if (!user || user.toString().match(/login/i)) {
        document.getElementById("newBugError").hidden = '';
        document.getElementById("newBugError").innerHTML = "Please log in";
        $("#newBugModal").reload(true);
        return false;
        //location.assign(document.getElementById("homeURL"));
        //location.reload(true);
    }
    else if (!(title && desc)) {
        document.getElementById("newBugError").hidden = '';
        document.getElementById("newBugError").innerHTML = "Please fill in title and description";
        $("#newBugModal").reload(true);
        return false;
        //location.assign(document.getElementById("homeURL"));
        //location.reload(true);
    }
    return true;
}

$(document).ready(function () {
    $("#newBugForm").on("submit", function (e) {
        var postData = $(this).serializeArray();
        var title = $("#newBugTitle").val();
        var owner = $("#newBugOwner").val();
        var desc = $("#newBugDesc").val();
        var status = document.querySelector('input[name=newBugStatusBtnGrp]:checked').value;
        var user = document.getElementById("user-list").value;

        var postData = 'Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
        var formURL = document.getElementById("homeURL") + "/php/newBug.php";
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
                $('#newBugForm .modal-header .modal-title').html("New bug added");
                $('#newBugForm .modal-body').html(data);
                $("#newBugSubmit").remove();
                $("#newBugForm").reset(); // clear old data
            },
            error: function (jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });

    $("#newBugSubmit").on('click', function() {
        if (dataValid()) {
            $("#newBugForm").submit();
            $("#newBugModal").hide();
            location.reload(true);
        }
    });
});
