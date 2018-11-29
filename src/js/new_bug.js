// newBug java script, invoked from newBug modal ...
$(document).ready(function () {
    $("#newBugForm").on("submit", function(e) {
        var postData = $(this).serializeArray();
        var title = $("#newBugTitle").val();
        var owner = $("#newBugOwner").val();
        var desc = $("#newBugDesc").val();
        var status = document.querySelector('input[name=newBugStatusBtnGrp]:checked').value;

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
                    $('#newBugForm .modal-header .modal-title').html("Result");
                    $('#newBugForm .modal-body').html(data);
                    $("#newBugSubmit").remove();
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
