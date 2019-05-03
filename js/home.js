(function(jQuery) {
  equalheight = function(container){
    var currentTallest = 0;
    var currentRowStart = 0;
    var rowDivs = [];
    var jQueryel;
    var topPosition = 0;

    jQuery(container).each(function() {
      jQueryel = jQuery(this);
      jQuery(jQueryel).height('auto');
      topPostion = jQueryel.position().top;

      if (currentRowStart != topPostion) {
        for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
          rowDivs[currentDiv].height(currentTallest);
        }
        rowDivs.length = 0; // empty the array
        currentRowStart = topPostion;
        currentTallest = jQueryel.height();
        rowDivs.push(jQueryel);
      } else {
        rowDivs.push(jQueryel);
        currentTallest = (currentTallest < jQueryel.height()) ? (jQueryel.height()) : (currentTallest);
      }
      for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
        rowDivs[currentDiv].height(currentTallest);
      }
    });
    return currentTallest;
  };

  jQuery(window).ready(function() {
    onResize();
    jQuery('.tnp-email').attr('placeholder', 'E-mail');
  });

  function onResize() {
    equalheight('.menu-home-container .description');
    equalheight('.menu-home-double-menu-container .description');
    var height = equalheight('.menu-home-triple-menu-container .description');
    jQuery('.menu-home-triple-menu-container .widget').height(201 + 40 + height);
    equalheight('.menu-home-quadruple-menu-container .description');
    equalheight('.app-category .app-content');
    equalheight('.item-list li');
  }

  jQuery(window).resize(onResize);

})(jQuery);
