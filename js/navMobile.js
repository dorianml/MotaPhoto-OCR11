let burger = document.getElementById('navTrigger'),
    nav    = document.getElementById('navMenu');

burger.addEventListener('click', function(e){
    console.log('openTheHam')
  this.classList.toggle('active');
  nav.classList.toggle('active');
});