// newBug java script, invoked from newBug modal ...
$(document).ready(function () {
    function dataValid() {
        var title = $("#newBugTitle").val();
        var desc = $("#newBugDesc").val();
        var user = document.getElementById("user-list").value;

        if (!user || user.toString().match(/login/i)) {
            document.getElementById("newBugError").hidden = false;
            document.getElementById("newBugError").innerHTML = "Please log in";
            $("#newBugModal").reload(true);
            return false;
        }
        else if (!(title && desc)) {
            document.getElementById("newBugError").hidden = false;
            document.getElementById("newBugError").innerHTML = "Please fill in title and description";
            $("#newBugModal").reload(true);
            return false;
        }

        return true;
    }

    $("#newBugForm").on("submit", function (e) {
        var postData = $(this).serializeArray();
        var title = $("#newBugTitle").val();
        var owner = $("#newBugOwner").val();
        var desc = $("#newBugDesc").val();
        var status = document.querySelector('input[name=newBugStatusBtnGrp]:checked').value;
        var user = document.getElementById("user-list").value;

        var postData = 'Title=' + title + '&Owner=' + owner + '&Description=' + desc + '&Status=' + status + '&UserName=' + user;
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function (data, textStatus, jqXHR) {
                //$('#newBugForm .modal-header .modal-title').html("New bug added");
                //$('#newBugForm .modal-body').html(data);
                //$("#newBugSubmit").remove();  NO ... this makes the button disappear ... no good
                //document.getElementById("#newBugForm").reset(); // clear old data ... does not work, backdrop remains ...
                //$(this).find("input, textarea, select").val([]); // clear old data ... no, only makes backdrop remain ...
            },
            error: function (jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });

    function hideModal() {
        $("#newBugModal").hide(); // use this not $("#newBugModal").modal('hide'); else modal does not show later
        $('.modal-backdrop').hide();
        document.getElementById("newBugError").hidden = true; // let user make a new error first
    }

    function refreshPage() {
        if (window.XMLHttpRequest) {
            http = new XMLHttpRequest();
        }
        else {
            http = new ActiveXObject("Microsoft.XMLHTTP");
        }

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                //getCards("Current Iteration", "currentIteration");
                //getCards("Backlog", "backlog");
                getCards("Bugs", "bugs");
            }
        };
    }
    $("#newBugSubmit").on('click', function() {
        if (dataValid()) {
            $("#newBugForm").submit();
            hideModal();
            refreshPage(); // this does not appear to work here .. research
            //location.reload(true); ... TODO: last bug is that new screen does not have updated bug ... but doing this here makes us lose it!
        }
    });
});
