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

         // users is for the User Login; formUsers is to populate owner fields in forms.
         users =  "<option default=\"login\">User Login</option>";
         formUsers = "<option default=\"none\">None Selected</option>";
         for (x in data)
         {
           users += "<option value=\"" + data[x].userName + "\">" + data[x].userName + "</option>";
           formUsers +=  "<option value=\"" + data[x].userName + "\">" + data[x].userName + "</option>";
         }

         document.getElementById("user-list").innerHTML = users;
         document.forms["newStoryForm"].elements["newStoryOwner"].innerHTML = formUsers;
         document.forms["newBugForm"].elements["newBugOwner"].innerHTML = formUsers;
         document.forms["editCardForm"].elements["editCardOwner"].innerHTML = formUsers;
      }
   };


   http.open('POST', 'php/userHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get');
}