"use strict";

$(function() {
    function openMenu()
    {
        var bodyScrollTop = $body.scrollTop(),
            windowHeight  = $(window).height(),
            bodyHeight    = $body.height();

        $mainMenu.addClass('open');
        $body    .addClass('menuOpen');

        $menuContainer.scrollTop(0);
        $menuContainer.css({
            top:    bodyScrollTop,
            bottom: bodyHeight - windowHeight - bodyScrollTop
        });

        $overlay.css({
            top:    bodyScrollTop,
            bottom: bodyHeight - windowHeight - bodyScrollTop
        });
    }
    function closeMenu()
    {
        $mainMenu.removeClass('open');
        $body.removeClass('menuOpen');
    }
    function scrollHandler(event)
    {
        if ($(this).scrollTop() > event.data.top) {
            $('body').addClass('sticky');
        }
        else {
            $('body').removeClass('sticky');
        }
    }

    var $body          = $('body'),
        $mainMenu      = $('#mainMenu'),
        $menuContainer = $mainMenu.find('.menuContainer'),
        $overlay       = $mainMenu.find('.overlay');

    $mainMenu.find('.openMenu').on('click', openMenu);
    $mainMenu.find('.header')  .on('click', closeMenu);
    $overlay                   .on('click', closeMenu);
    $(window).on('scroll', {top: $mainMenu.offset().top}, scrollHandler);
});