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
               " <!-- Story Card -->\n" +
               "<div class=\"card filterDiv State3\" style=\"width: auto;\">\n" +
               "   <div class=\"card-body\">\n" +
               "      <h5 class=\"card-title\">State 3 Card title</h5>\n" +
               "      <h6 class=\"card-subtitle mb-2 text-muted\">Card subtitle</h6>\n" +
               "      <p class=\"card-text\">Some quick example text to build on the card title and make up the bulk of the card's content.</p>\n" +
               "   </div>\n" +
               "</div> <!--End Story Card --> \n"
         }
         console.log(cards);
         document.getElementById("left-col").innerHTML = cards;
      }
   };

   http.open('POST', 'php/cardHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get&list=' + list);
}