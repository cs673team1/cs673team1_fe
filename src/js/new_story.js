// newStory java script, invoked from newStory modal ...
$(document).ready(function () {
    $("#newStoryForm").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var title = $("#newStoryTitle").val();
        var owner = $("#newStoryOwner").val();
        var desc = $("#newStoryDesc").val();
        var status = document.querySelector('input[name=newStoryStatusBtnGrp]:checked').value;

        // TODO: when this alert exits we revert to the php file as a web page ... ick ...
        if (!(title && desc)) {
            alert("Please fill in title and description");
        }
        else {
            var postData = 'Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status;
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function (data, textStatus, jqXHR) {
                    $('#newStoryForm .modal-header .modal-title').html("Result");
                    $('#newStoryForm .modal-body').html(data);
                    $("#newStorySubmit").remove();
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
