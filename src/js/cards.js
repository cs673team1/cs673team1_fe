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

         // TODO: Make next line about card
         //users =  "<option default=\"login\">User Login</option>";
         for (x in data)
         {
            // TODO: Make next line about card
            //users += "<option value=\"" + data[x].userName + "\">" + data[x].userName + "</option>";
         }
         // TODO: Make next line about card
         //document.getElementById("user-list").innerHTML = users;
      }
   };

   http.open('POST', 'php/cardHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get&list=' + list);
}