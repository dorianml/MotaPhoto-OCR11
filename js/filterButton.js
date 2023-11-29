$(function () {
    var splitBtn = $(".x-split-button");
    var splitBtn2 = $(".x-split-button2");
    var splitBtn3 = $(".x-split-button3");

   
    $("button.x-button-drop").on("click", function () {
      splitBtn.addClass("open");
/* DISPLAY THE SELECTED CAT */ 
      $(".ajax-category-link").on("click", function () {
        const categoryName = $(this).text().toUpperCase();
        $("button.x-button-drop").text(categoryName);
      });
  
      $(".x-button-drop-menu").removeClass("closeFilter").css("display", "block");
    });
  
    $(".x-split-button").click(function (event) {
      event.stopPropagation();
    });
  
    $("html").on("click", function () {
      splitBtn.removeClass("open");
      $(".x-button-drop-menu").addClass("closeFilter").css("display", "none");
    });
  
    // For Button 2
    $("button.x-button2-drop").on("click", function () {
      splitBtn2.addClass("open");
      /* DISPLAY THE SELECTED FORMAT */ 
      $(".ajax-format-link").on("click", function () {
        const formatName = $(this).text().toUpperCase();
        $("button.x-button2-drop").text(formatName);
      });
  
      $(".x-button2-drop-menu").removeClass("closeFilter").css("display", "block");
    });
  
    $(".x-split-button2").click(function (event) {
      event.stopPropagation();
    });
  
    $("html").on("click", function () {
      splitBtn2.removeClass("open");
      $(".x-button2-drop-menu").addClass("closeFilter").css("display", "none");
    });
  
    // For Button 3
    $("button.x-button3-drop").on("click", function () {
      splitBtn3.addClass("open");
      /* DISPLAY THE SELECTED DATE FILTER */ 
      $(".ajax-time-link").on("click", function () {
        const dateName = $(this).text().toUpperCase();
        $("button.x-button3-drop").text(dateName);
      });
  
      $(".x-button3-drop-menu").removeClass("closeFilter").css("display", "block");
    });
  
    $(".x-split-button3").click(function (event) {
      event.stopPropagation();
    });
  
    $("html").on("click", function () {
      splitBtn3.removeClass("open");
      $(".x-button3-drop-menu").addClass("closeFilter").css("display", "none");
    });
  });
  