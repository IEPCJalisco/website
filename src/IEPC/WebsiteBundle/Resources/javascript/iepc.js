"use strict";

$(function(){
    if ('ontouchstart' in window || navigator.maxTouchPoints) {
        $('html').addClass('touch-enabled');
    }
});