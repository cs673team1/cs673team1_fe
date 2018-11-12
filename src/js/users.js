function getUsers()
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
         users =  "";
         for (x in data)
         {
           users += "<li><a href=\"#\">" + data[x].userName + "</a></li>\n";
         }

         document.getElementById("user-list").innerHTML = users;
      }
   };

   http.open('POST', 'php/userHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get');
}