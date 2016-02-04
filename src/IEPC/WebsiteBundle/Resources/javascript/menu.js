"use strict";

$(function(){
    function openMenu() {
        var bodyScrollTop = $body.scrollTop();

        $mainMenu.addClass('open');
        $body.addClass('menuOpen');

        $menuContainer.scrollTop(0);
        $menuContainer.css({
            top:    bodyScrollTop,
            bottom: -bodyScrollTop
        });

        $overlay.css({
            top:    bodyScrollTop,
            bottom: -bodyScrollTop
        });
    }
    function closeMenu() {
        $mainMenu.removeClass('open');
        $body.removeClass('menuOpen');
    }

    var $mainMenu      = $('#mainMenu'),
        $menuContainer = $mainMenu.find('.menuContainer'),
        $overlay       = $mainMenu.find('.overlay'),
        $body          = $('body');

    $mainMenu.find('.openMenu').on('click', openMenu);
    $mainMenu.find('.header')  .on('click', closeMenu);
    $mainMenu.find('.overlay') .on('click', closeMenu);
});