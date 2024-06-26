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
  };

  jQuery(window).ready(function() {
    onResize();
    jQuery('.tnp-email').attr('placeholder', 'E-mail');

    printIncrement();
  });

  function onResize() {
    equalheight('.menu-home-container .description');
    equalheight('.menu-home-double-menu-container .description');
    if (jQuery("#menu-home-triple-menu li").css("display") === "inline-block" ) {
      equalheight('.menu-home-triple-menu-container .widgetizedArea');
    } else {
      jQuery('.menu-home-triple-menu-container .widgetizedArea').each(function() {
        jQuery(this).height('auto');
      });
    }
    equalheight('.menu-home-quadruple-menu-container .description');
    equalheight('.app-category .app-content');
    equalheight('.item-list li');
  }

  jQuery(window).resize(onResize);

  jQuery(window).scroll(function(){
    printIncrement();
  });

  function printIncrement() {
    var numbersSection = document.getElementById("numbers-section");
    if (numbersSection !== null && !isElementOutViewport(numbersSection) && jQuery("#numbers-section").attr("data-start") === "false") {
      increment(jQuery("#increment-countries"));
      increment(jQuery("#increment-institutions"));
      increment(jQuery("#increment-partners"));
      jQuery("#numbers-section").attr("data-start","true");
    }
  }

  function increment(elementToIncrement) {
    var element = jQuery(elementToIncrement);
    var number = element.attr("data-top");
    number = parseInt(number,10);
    var i=0;
    function incrementItem() {
      i++;
      element.html(i);
      if (i===number) {
        clearInterval(interval);
      }
    }
    var incrementTime = 1000/number;
    var interval = setInterval(incrementItem, incrementTime);
  }

  function isElementOutViewport(el){
    var rect = el.getBoundingClientRect();
    return rect.bottom < 0 || rect.right < 0 || rect.left > window.innerWidth || rect.top > window.innerHeight;
  }
})(jQuery);
