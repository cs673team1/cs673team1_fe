// newStory java script, invoked from newStory modal ...
$(document).ready(function () {
    function dataValid() {
        var title = $("#newStoryTitle").val();
        var desc = $("#newStoryDesc").val();
        var user = document.getElementById("user-list").value;

        if (!user || user.toString().match(/login/i)) {
            document.getElementById("newStoryError").hidden = false;
            document.getElementById("newStoryError").innerHTML = "Please log in";
            $("#newStoryModal").reload(true);
            return false;
        }
        else if (!(title && desc)) {
            document.getElementById("newStoryError").hidden = false;
            document.getElementById("newStoryError").innerHTML = "Please fill in title and description";
            $("#newStoryModal").reload(true);
            return false;
        }

        return true;
    }

    $("#newStoryForm").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var title = $("#newStoryTitle").val();
        var owner = $("#newStoryOwner").val();
        var desc = $("#newStoryDesc").val();
        var status = document.querySelector('input[name=newStoryStatusBtnGrp]:checked').value;
        var user = document.getElementById("user-list").value;

        var postData = 'Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
                //$('#newStoryForm .modal-header .modal-title').html("Added new Story");
                //$('#newStoryForm .modal-body').html(data);
                //$("#newStorySubmit").remove(); ... NO, hides button
                //$("#newStorySubmit").reset(); // clear old data ... this does not work ...
            },
            error: function (jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });

    function hideModal() {
        $("#newStoryModal").hide();
        $('.modal-backdrop').hide();
        document.getElementById("newStoryError").hidden = true; // let user make a new error first
    }

    $("#newStorySubmit").on('click', function() {
        if (dataValid()) {
            $("#newStoryForm").submit();
            hideModal();
        }
    });

    $("#newStoryClose").on('click', function() {
        hideModal();
    });
});
