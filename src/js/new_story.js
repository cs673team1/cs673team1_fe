// newStory java script, invoked from newStory modal ...
$(document).ready(function () {
    $("#newStoryForm").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var title = $("#newStoryTitle").val();
        var owner = $("#newStoryOwner").val();
        var desc = $("#newStoryDesc").val();
        var status = document.querySelector('input[name=newStoryStatusBtnGrp]:checked').value;
        var user = document.getElementById("user-list").value;

        if (!user || user.toString().match(/login/i)) {
            alert("Please log in");
            location.assign(document.getElementById("homeURL"));
            location.reload(true);
        }
        else if (!(title && desc)) {
            alert("Please fill in title and description");
            location.assign(document.getElementById("homeURL"));
            location.reload(true);
        }
        else {
            var postData = 'Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
            var formURL = document.getElementById("homeURL") + "/" + $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    $('#newStoryForm .modal-header .modal-title').html("Added new Story");
                    $('#newStoryForm .modal-body').html(data);
                    $("#newStorySubmit").remove();
                    $("#newStorySubmit").reset(); // clear old data
                    location.reload(true);
                },
                error: function (jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        }
    });

    $("#newStorySubmit").on('click', function() {
        $("#newStoryForm").submit();
    });
});
