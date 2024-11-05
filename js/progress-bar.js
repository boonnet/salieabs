(function ($) {
  "use strict";

  let processScroll = () => {
    let docElem = document.documentElement, 
      docBody = document.body,
      scrollTop = docElem['scrollTop'] || docBody['scrollTop'],
        scrollBottom = (docElem['scrollHeight'] || docBody['scrollHeight']) - window.innerHeight,
      scrollPercent = scrollTop / scrollBottom * 100 + '%';    
    // console.log(scrollTop + ' / ' + scrollBottom + ' / ' + scrollPercent);    
      document.getElementById("progress-bar").style.setProperty("--scrollAmount", scrollPercent);	
  }  
  document.addEventListener('scroll', processScroll);


//end of page
})(jQuery);

