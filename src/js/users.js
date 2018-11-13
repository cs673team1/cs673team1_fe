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
         users =  "<option default=\"login\">User Login</option>";
         for (x in data)
         {
           users += "<option value=\"" + data[x].userName + "\">" + data[x].userName + "</option>";
         }

         document.getElementById("user-list").innerHTML = users;
      }
   };

   http.open('POST', 'php/userHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get');
}