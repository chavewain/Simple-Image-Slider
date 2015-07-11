
jQuery(function(){

    var slideshow = jQuery('.cycle-slideshow');
    maxSlides = slideshow.data('cycle.opts').slideCount;
    

slideshow.on({
    'cycle-update-view': function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
    UpdateTitles();
    }
});

function UpdateTitles(){
    var currentSlide = slideshow.data('cycle.opts').currSlide;
    activeSlide = jQuery(".cycle-slide-active");
    activeTitle = activeSlide.data('title');
    activeSubTitle = activeSlide.data('subtitle');
    activeUrl = activeSlide.data('url');
    activeUrlTarget = activeSlide.data('target');


    
    if(currentSlide == 0){
        nextTitle = activeSlide.next().data('title');
        prevTitle = jQuery(".cycle-slide:last-child").data('title');
    }
    else if(currentSlide == maxSlides-1){
        prevTitle = activeSlide.prev().data('title');
        nextTitle = jQuery(".cycle-slide").eq(0).data('title');
    }
    else {
        nextTitle = activeSlide.next().data('title');
        prevTitle = activeSlide.prev().data('title');
    }
    
    jQuery('.slide-title-container h1').hide().html(activeTitle).fadeIn(500);
    jQuery('.slide-title-container h4').hide().html(activeSubTitle).fadeIn(500);
    
    jQuery('.gotonews').attr('href', activeUrl);
    jQuery('.gotonews').attr('target', activeUrlTarget);
    jQuery('#prev .text .table-cell').html(prevTitle);
    jQuery('#next .text .table-cell').html(nextTitle);
}

UpdateTitles();



// ANIMATE SLIDE ARROW


jQuery(document).ready(function(){
        jQuery("#next").hoverIntent(animateRightHover,animateRightLeave);
        jQuery("#prev").hoverIntent(animateLeftHover,animateLeftLeave);
    }); // close document.ready

    function animateRightHover(){jQuery(this).animate({right:0},200);}
    function animateRightLeave(){jQuery( this ).animate({right: "-236"}, 200 );}
    function animateLeftHover(){jQuery(this).animate({left:0},200);}
    function animateLeftLeave(){jQuery( this ).animate({left: "-236"}, 200 );}
 });   



