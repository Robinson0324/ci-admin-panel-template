$(function() {

    $('#side-menu').metisMenu();

});



//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse')
        }

        height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    })
    //Check to see if the window is top if not then display button
    var dir_info = 0;
    $(window).scroll(function(){

        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').show();
            $('.scrollToDown').hide();
        }else{
            $('.scrollToTop').fadeOut();
            $('.scrollToDown').show();
        }

        if((dir_info-$(this).scrollTop())>0){
            $('.scrollToTop').show();
            dir_info = $(this).scrollTop();
        }else if(($(this).scrollTop()-dir_info)>0){
            $('.scrollToDown').show();
            dir_info = $(this).scrollTop();
        }
        if($(this).scrollTop()==0){
            $('.scrollToDown').show();
            dir_info = 0;
        }

    });
    $(window).scroll();
    //Click event to scroll to top
    $('.scrollToTop').click(function(){

        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
    //Click event to scroll to down
    $('.scrollToDown').click(function(){

        $('html, body').animate({scrollTop : $('body').height()},800);
        return false;
    });
})

//Loading image show and search condition control
$(document).ajaxSend(function(event, request, settings) {
    $('#loading-indicator').show();
});
$(document).ajaxComplete(function(event, request, settings) {
    $('#loading-indicator').hide();
});
$('#error').on('click',function(){
    $(this).addClass('hidden');
})

