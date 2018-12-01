function getActivities()
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
         actLog =  "<ul>";
         for (x in data)
         {
            actLog +=
               "<li>" + data[x].time + ": " + data[x].content + "</li>";
         }

         actLog += "</ul>";

         document.getElementById("activityBody").innerHTML = actLog;
      }
   };

   http.open('POST', 'php/activityHandler.php', true);
   http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   http.send('request=get');
}