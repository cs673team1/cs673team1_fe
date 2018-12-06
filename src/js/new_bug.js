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

    function clearFormFields () {
        document.getElementById("newBugTitle").value = "";
        //document.getElementById("newBugOwner").value = null; // TODO: this is not right for drop down, fix (null, "", and "None" all fail)
        document.getElementById("newBugDesc").value = "";
    }

    function hideModal() {
        $("#newBugModal").hide(); // use this not $("#newBugModal").modal('hide'); else modal does not show later
        $('.modal-backdrop').hide();
        document.getElementById("newBugError").hidden = true; // let user make a new error first
    }

    // WARNING: this function MUST track any changes made to getCards in cards.js
    function getCardsForNewBug(list, tag)
    {
        var http = (window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP"));

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const data = JSON.parse(this.responseText);

                let cards = "";
                let filter = (list === "Current Iteration") ? "filterDiv " : "";
                let showFilter   = (list === "Current Iteration") ? " show" : "";
                for (x in data) {
                    cards +=
                        "<!-- Story Card -->\n" +
                        "<div onclick=\"populateEditCard(" + data[x].cardID + ")\" class=\"card " + filter + data[x].status + showFilter + "\" style=\"width: auto;\">\n" +
                        "   <div class=\"card-body\">\n" +
                        "      <h7 class=\"card-id mb-2 text-muted\">ID: " + data[x].cardID + "</h7>\n" +
                        "      <h5 class=\"card-title\">" + data[x].cardName + " <i>(" + data[x].status + ")</i></h5>\n" +
                        "      <h6 class=\"card-subtitle mb-2 text-muted\">Owner: " + data[x].owner + "</h6>\n" +
                        "      <h6 class=\"HiddenField\">Hidden Field</h6>\n" +
                        "      <p class=\"card-text\">" + data[x].description + "</p>\n" +
                        "      <div class=\"btn-group\">\n" +
                        "         <button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\">\n" +
                        "            Actions\n" +
                        "            <span class=\"caret\"></span>\n" +
                        "         </button>\n" +
                        "         <ul class=\"dropdown-menu\" role=\"menu\">\n" +
                        "            <li onclick=\"moveCard(" + data[x].cardID + ")\"><a href=\"#\">Move</a></li>\n" +
                        "            <li><a type=\"button\" data-toggle=\"modal\" data-target=\"#editCardModal\">Edit</a></li>\n" +
                        "            <li class=\"divider\"></li>\n" +
                        "            <li onclick=\"archiveCard(" + data[x].cardID + ")\"><a href=\"#\">Archive</a></li>\n" +
                        "         </ul>\n" +
                        "      </div>\n" +
                        "   </div>\n" +
                        "<br>" +
                        "</div> <!--End Story Card -->\n";
                }

                document.getElementById(tag).innerHTML = cards;
            }
        };

        http.open('POST', 'php/cardHandler.php', true);
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http.send('request=get&listname=' + list);
    }

    function refreshPage() {
        getCardsForEditCard("Current Iteration", "currentIteration");
        getCardsForEditCard("Backlog", "backlog");
        getCardsForEditCard("Bugs", "bugs");
        $('body').attr("style", "overflow:auto"); // re-enable scrolling!
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
            // potentially do async: true, here
            success: function (data, textStatus, jqXHR) {
                hideModal();
                clearFormFields();
                refreshPage();
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

     $("#newBugSubmit").on('click', function() {
        if (dataValid()) {
            $("#newBugForm").submit();
        }
    });

    $("#newBugClose").on('click', function() {
        hideModal();
        clearFormFields();
    });
});
