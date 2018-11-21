function getCards(list, tag)
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
                "<div class=\"card\" style=\"width: auto;\">\n" +
                "   <div class=\"card-body\">\n" +
                "      <h7 class=\"card-id\">" + data[x].cardID +"</h7>\n" +
                "      <h5 class=\"card-title\">" + data[x].cardName + " <i>(" + data[x].status + ")</i></h5>\n" +
                "      <h6 class=\"card-subtitle mb-2 text-muted\">Owner</h6>\n" +
                "      <p class=\"card-text\">" + data[x].description + "</p>\n" +
                "      <div class=\"btn-group\">\n" +
                "         <button type=\"button\" class=\"btn btn-primary dropdown-toggle\" data-toggle=\"dropdown\">\n" +
                "            Actions\n" +
                "            <span class=\"caret\"></span>\n" +
                "         </button>\n" +
                "         <ul class=\"dropdown-menu\" role=\"menu\">\n" +
                "            <li><a href=\"#\">Move</a></li>\n" +
                "            <li><a href=\"#\">Edit</a></li>\n" +
                "            <li class=\"divider\"></li>\n" +
                "            <li><a type=\"button\" data-toggle=\"modal\" data-target=\"#EditModal\">Delete</a></li>\n" +
                "         </ul>\n" +
                "      </div>\n" +
                "   </div>\n" +
                "</div> <!--End Story Card -->\n" +
                "<br>";
         }

         document.getElementById(tag).innerHTML = cards;
      }
   };

   http.open('POST', 'php/cardHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get&list=' + list);
}