// Get the modal
var modal = document.getElementById('myModal');
// Récupérez la valeur de votre single post page (remplacez ceci par la logique appropriée)

// Get the button that opens the modal
var btn = document.getElementsByClassName("menu-item menu-item-type-custom menu-item-object-custom menu-item-33");
var btnContact = document.getElementById("contactPostLink");

// Get the <span> element that closes the modal
var span = document.getElementById('close');

// When the user clicks on the button, open the modal
btn[0].onclick = function() {
    modal.style.display = "block";
    $custom_field_value = get_field('type');
    document.getElementById("REF").value = get_field('reference');
    $(document).ready(function() {
        $("#REF").val('HELLO');
    });
}
btnContact.onclick = function() {
    modal.style.display = "block";
   
    // $(document).ready(function() {
    //     $("#wpforms-34-field_3").val('HELLO');
    // });
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
