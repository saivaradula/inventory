// common way to initialize jQuery
jQuery(function($) {
    // Read URL.
    var strURL = window.location.pathname;
    var arrURL = strURL.split("/");
    var strPath = arrURL[1].toLowerCase();
    jQuery('.nav-list li').removeClass('active');
    $('.'+ strPath +'_menu').addClass('active');
    $('.'+ strPath +'_menu .submenu').show();
});


function showLoader(strText) {
    jQuery('#loadingmsg').html(strText)
    jQuery('#dvLoading').show();
    jQuery('#loadingimg').animate({height: "33%"});
    jQuery('#dvLoading').animate({height: "100px"});
}

function hideLoader() {
    jQuery('#loadingimg').animate({height: "0px"});
    jQuery('#dvLoading').animate({height: "20px"});
    jQuery('#dvLoading').hide();
    jQuery('#loadingmsg').html('Please wait...');
}

