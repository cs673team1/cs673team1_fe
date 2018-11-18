function getCards(list)
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

         cards =  "";
         for (x in data)
         {
            cards +=
               "<!-- Story Card -->\n" +
               "<div class=\"card filterDiv State1\" style=\"width: auto;\">\n" +
               "   <div class=\"card-body\">\n" +
               "      <h5 class=\"card-title\">State 1 Card title</h5>\n" +
               "      <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6>\n" +
               "      <p class=\"card-text\">Some quick example text to build on the card title and make up the bulk of the card's\n" +
               "         content.</p>\n" +
               "      <div class=\"btn-group\">\n" +
               "         <button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\">\n" +
               "            Move\n" +
               "            <span class=\"caret\"></span>\n" +
               "         </button>\n" +
               "         <ul class=\"dropdown-menu\" role=\"menu\">\n" +
               "            <li><a href=\"#\">Action</a></li>\n" +
               "            <li><a href=\"#\">Another action</a></li>\n" +
               "            <li><a href=\"#\">Something else here</a></li>\n" +
               "            <li class=\"divider\"></li>\n" +
               "            <li><a href=\"#\">Separated link</a></li>\n" +
               "         </ul>\n" +
               "      </div>\n" +
               "   </div>\n" +
               "</div> <!--End Story Card -->\n" +
               "<br>";
         }
         //console.log(cards);
         document.getElementById("left-col").innerHTML = cards;
         console.log("left-col content\n" + document.getElementById("left-col").innerHTML);
      }
   };

   http.open('POST', 'php/cardHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get&list=' + list);
}