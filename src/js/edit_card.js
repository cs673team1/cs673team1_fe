// editCard java script, invoked from editCard modal ...
$(document).ready(function () {
    function dataValid() {
        var title = $("#editCardTitle").val();
        var desc = $("#editCardDesc").val();
        var user = document.getElementById("user-list").value;

        if (!user || user.toString().match(/login/i)) {
            document.getElementById("editCardError").hidden = false;
            document.getElementById("editCardError").innerHTML = "Please log in";
            $("#editCardModal").reload(true);
            return false;
        }
        else if (!(title && desc)) {
            document.getElementById("editCardError").hidden = false;
            document.getElementById("editCardError").innerHTML = "Please fill in title and description";
            $("#editCardModal").reload(true);
            return false;
        }

        return true;
    }

    function hideModal() {
        $("#editCardModal").hide();
        $('.modal-backdrop').hide();
        document.getElementById("editCardError").hidden = true; // let user make a new error first
    }

    // this function MUST track any changes in cards.js
    function getCards(list, tag)
    {
        if (window.XMLHttpRequest) {
            http = new XMLHttpRequest();
        }
        else {
            http = new ActiveXObject("Microsoft.XMLHTTP");
        }

        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const data = JSON.parse(this.responseText);

                cards = "";
                filter = (list == "Current Iteration") ? "filterDiv " : "";
                for (x in data) {
                    cards +=
                        "<!-- Story Card -->\n" +
                        "<div onclick=\"populateEditCard(" + data[x].cardID + ")\" class=\"card " + filter + data[x].status + "\" style=\"width: auto;\">\n" +
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
        getCards("Current Iteration", "currentIteration");
        getCards("Backlog", "backlog");
        getCards("Bugs", "bugs");
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
                hideModal();
                refreshPage();
                //$('#editCardForm .modal-header .modal-title').html("Edited card");
                //$('#editCardForm .modal-body').html(data);
                //$("#editCardSubmit").remove(); ... NO, hides the button!
                // do not reset data ... maybe user wants to keep on editing
            },
            error: function (jqXHR, status, error) {
                console.log(status + ": " + error);
            }
        });
        e.preventDefault();
    });

    $("#editCardSubmit").on('click', function() {
        if (dataValid()) {
            $("#editCardForm").submit();
        }
    });

    $("#editCardClose").on('click', function() {
        hideModal();
    });
});
