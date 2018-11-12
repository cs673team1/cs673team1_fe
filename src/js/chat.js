function getMessages()
{
   if (window.XMLHttpRequest)
   {
      http = new XMLHttpRequest();
   }
   else {
      http = new ActiveXObject("Microsoft.XMLHTTP");
   }

   http.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200)
      {
         const data = JSON.parse(this.responseText);
         msgs =  "";
         for (x in data)
         {
            msgs +=
               "<div class=\'\'>\n" +
               "   <div class=\'panel panel-white post panel-shadow\'>\n" +
               "      <div class=\'post-heading\'>\n" +
               "         <div class=\'pull-left image\'>\n" +
               "            <img src=\'http://bootdey.com/img/Content/user_1.jpg\' class=\'img-circle avatar\' alt=\'user profile image\' />\n" +
               "         </div>\n" +
               "         <div class=\"pull-left meta\">\n" +
               "            <div class=\"title h5\">\n" +
               "               <a href=\"#\"><b>" + data[x].user_userID + "</b></a>\n" +
               "            </div>\n" +
               "            <h6 class=\"text-muted time\">" + data[x].timeSent + "</h6>\n" +
               "         </div>\n" +
               "      </div>\n" +
               "      <div class=\"card\" style=\"height: 12rem\">\n" +
               "         <p class=\"card-text\">" + data[x].content + "</p>\n" +
               "      </div>\n" +
               "   </div>\n" +
               "</div>\n\n";
         }

         document.getElementById("chatPane").innerHTML = msgs;
      }
   };

   http.open('POST', 'php/chatHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get');
}

function sendMessage()
{
   if (window.XMLHttpRequest)
   {
      http = new XMLHttpRequest();
   }
   else {
      http = new ActiveXObject("Microsoft.XMLHTTP");
   }

   http.onreadystatechange = function ()
   {
      getMessages();
   }

   http.open('POST', 'php/chatHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=send&user=Allen Bouchard&content=' + document.getElementById("chat-content").value);
}


