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

function moveCard(cardID) {
    var user = document.getElementById("user-list").value;
    if (!user || user.toString().match(/login/i)) {
        alert("Please log in");
    }
    else {
        moveCardInner(cardID, user);
    }
}

function moveCardInner(cardID, user) {
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    }
    else {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getCards("Current Iteration", "currentIteration");
            getCards("Backlog", "backlog");
            getCards("Bugs", "bugs");
        }
    };

    http.open('POST', 'php/cardHandler.php', true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('request=move&cardid=' + cardID + "&UserName=" + user);
}

function archiveCard(cardID) {
    var user = document.getElementById("user-list").value;
    if (!user || user.toString().match(/login/i)) {
        alert("Please log in");
    }
    else {
        archiveCardInner(cardID, user);
    }
}

function archiveCardInner(cardID, user) {

    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    }
    else {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            getCards("Current Iteration", "currentIteration");
            getCards("Backlog", "backlog");
            getCards("Bugs", "bugs");
        }
    };

    http.open('POST', 'php/cardHandler.php', true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('request=delete&cardid=' + cardID + '&UserName=' + user);
}

function populateEditCard(cardID) {
    if (window.XMLHttpRequest) {
        http = new XMLHttpRequest();
    }
    else {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const data = JSON.parse(this.responseText);
            document.forms["editCardForm"].elements["editCardTitle"].value = data[0].cardName;
            document.forms["editCardForm"].elements["editCardID"].value = cardID;
            document.forms["editCardForm"].elements["editCardOwner"].value = data[0].owner;
            document.forms["editCardForm"].elements["editCardDesc"].value = data[0].description;

            statusElem = "editCardStatus" + data[0].status;
            statusElem = statusElem.replace("-", "");
            document.forms["editCardForm"].elements[statusElem].checked = true;
        }
    };

    http.open('POST', 'php/cardHandler.php', true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.send('request=get&cardid=' + cardID);
}
