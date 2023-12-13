// Get the collection of elements with the class "menu-item-33"
var contactButtons = document.getElementsByClassName("menu-item-33");

// Loop through each element in the collection
for (var i = 0; i < contactButtons.length; i++) {
  // Add an event listener to each element
  contactButtons[i].addEventListener("click", function (e) {
    console.log("CONTACT CLICKED");
  });
}
