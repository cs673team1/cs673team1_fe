// newBug java script, invoked from newBug modal ...
$(document).ready(function () {
    $("#newBugForm").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var title = $("#newBugTitle").val();
        var owner = $("#newBugOwner").val();
        var desc = $("#newBugDesc").val();
        var status = document.querySelector('input[name=newBugStatusBtnGrp]:checked').value;
        var user = document.getElementById("user-list").value;

        if (!user || user.toString().match(/login/i)) {
            alert("Please log in");
        }
        else if (!(title && desc)) {
            alert("Please fill in title and description");
        }
        else {
            var postData = 'Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    $('#newBugForm .modal-header .modal-title').html("New bug added");
                    $('#newBugForm .modal-body').html(data);
                    $("#newBugSubmit").remove();
                    $("#newBugSubmit").reset(); // clear old data
                    location.reload(true);
                },
                error: function (jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        }
    });

    $("#newBugSubmit").on('click', function() {
        $("#newBugForm").submit();
    });
});
