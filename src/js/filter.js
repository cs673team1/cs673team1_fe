filterSelection("all")
function filterSelection(criterion) {
   var filterTarget, i;
   filterTarget = document.getElementsByClassName("filterDiv");
   if (criterion == "all") criterion = "";
   for (i = 0; i < filterTarget.length; i++) {
      w3RemoveClass(filterTarget[i], "show");
      if (filterTarget[i].className.indexOf(criterion) > -1) w3AddClass(filterTarget[i], "show");
   }
}

function w3AddClass(element, name) {
   var i, arr1, arr2;
   arr1 = element.className.split(" ");
   arr2 = name.split(" ");
   for (i = 0; i < arr2.length; i++) {
      if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
   }
}

function w3RemoveClass(element, name) {
   var i, arr1, arr2;
   arr1 = element.className.split(" ");
   arr2 = name.split(" ");
   for (i = 0; i < arr2.length; i++) {
      while (arr1.indexOf(arr2[i]) > -1) {
         arr1.splice(arr1.indexOf(arr2[i]), 1);
      }
   }
   element.className = arr1.join(" ");
}

// Add active class to the current button (highlight it)
var btnContainer = document.getElementById("filterBtn");
var btns = btnContainer.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
   btns[i].addEventListener("click", function(){
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
   });
}