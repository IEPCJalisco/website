"use strict";

$(function(){
    var $footer = $('footer'),
        $handler = $footer.find('.handler');

    $handler.on('click', function(){
        $footer.toggleClass('open');
    });
});