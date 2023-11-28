$(function() {
    var splitBtn = $('.x-split-button');

    $('button.x-button-drop').on('click', function() {
      if (!splitBtn.hasClass('open'))
          splitBtn.addClass('open');
    });
  
    $('.x-split-button').click(function(event){
        event.stopPropagation();
    });

    $('html').on('click',function() {
       if (splitBtn.hasClass('open'))
          splitBtn.removeClass('open');
    });
});

// For Button 2
var splitBtn2 = $('.x-split-button2');

$('button.x-button2-drop').on('click', function() {
  if (!splitBtn2.hasClass('open'))
      splitBtn2.addClass('open');
});

$('.x-split-button2').click(function(event){
    event.stopPropagation();
});

$('html').on('click', function() {
    if (splitBtn2.hasClass('open'))
        splitBtn2.removeClass('open');
});

// For Button 3
var splitBtn3 = $('.x-split-button3');

$('button.x-button3-drop').on('click', function() {
  if (!splitBtn3.hasClass('open'))
      splitBtn3.addClass('open');
});

$('.x-split-button3').click(function(event){
    event.stopPropagation();
});

$('html').on('click', function() {
    if (splitBtn3.hasClass('open'))
        splitBtn3.removeClass('open');
});

$(document).ready(function() {
    var splitBtn3 = $('.x-split-button3');

    $('button.x-button3-drop').on('click', function() {
        if (!splitBtn3.hasClass('open'))
            splitBtn3.addClass('open');
    });

    $('.x-split-button3').click(function(event){
        event.stopPropagation();
    });

    $('html').on('click', function() {
        if (splitBtn3.hasClass('open'))
            splitBtn3.removeClass('open');
    });
});

