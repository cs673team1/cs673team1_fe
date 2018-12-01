function setCookieExp(cname, cvalue, exsecs) {
    var d = new Date();
    d.setTime(d.getTime() + (exsecs * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    var rvalue = getCookie(cname);
    if (rvalue != cvalue) {
        alert("You must turn on cookies in your browser to get " + cname + " to persist.");
    }
}

function setCookie(cname, cvalue) {
    document.cookie = cname + "=" + cvalue + ";path=/";
    var rvalue = getCookie(cname);
    if (rvalue != cvalue) {
        alert("You must turn on cookies in your browser to get " + cname + " to persist.");
    }
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}