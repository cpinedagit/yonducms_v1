/******** TOGGLE NAVIGATION *********/
$('#togglenav').click(function(){
   $('.masthead-nav').toggleClass('open'); 
});




/******** MINIFY HEADER WHEN SCROLL *********/
$(window).scroll(function(){
    var window_top = $(window).scrollTop();
  /*  $('.masthead--custom').height()*/
   if(window_top >= 60){
        $('.masthead--custom').addClass('minified');
    }else{
        $('.masthead--custom').removeClass('minified');                  
    }
                                        
});
