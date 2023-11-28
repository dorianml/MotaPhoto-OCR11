var modal = document.getElementById('myModal');
var btn = document.getElementById("menu-item-33");
var btnContact = document.getElementById("contactPostLink");
var span = document.getElementById('closeModal');

function openModal() {
    modal.style.display = "block";
}
    
btn.onclick = function() {
    openModal();
    console.log('OPEN2');
}

span.onclick = function() {
    console.log('CLOSE_SPAN');
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        console.log('CLOSE-Window');
        modal.style.display = "none";
    }
}

btnContact.onclick = function() {
    openModal();
    console.log('OPEN');
    var referenceFieldValue = get_field('reference');
    document.getElementsByClassName("wpforms-34-field_3").value = referenceFieldValue;
}