;(function($, window, document, undefined) {
    'use strict';
    var visibleContents, hiddenContents, icons, clickHandler, init;

    init = function() {
        visibleContents = $('.collapsible-content--visible');
        hiddenContents = visibleContents.next();
        icons = visibleContents.find('.collapsible-content--icon');
        visibleContents.on('click', clickHandler);
    };

    clickHandler = function( event ) {
        var index = visibleContents.index( this ),
            hiddenContent = $( hiddenContents[ index ] ),
            isHiddenContentShowing = hiddenContent.is(':visible');

        if ( ! isHiddenContentShowing ) {
            hiddenContent.slideDown( 500 );
        }
        else {
            hiddenContent.slideUp( 500 );
        }

        changeIcon( index, isHiddenContentShowing );

    }

    function changeIcon( index, isHiddenContentShowing ) {
        var iconElement = $( icons[ index ] ),
            showIcon =  iconElement.data( 'showIcon' ),
            hideIcon =  iconElement.data( 'hideIcon' ),
            removeClass, addClass;

        if ( isHiddenContentShowing ) {
            addClass = showIcon;
            removeClass = hideIcon;
        } else {
            addClass = hideIcon;
            removeClass = showIcon;
        }
        iconElement.removeClass( removeClass ).addClass( addClass );
    }

    $(document).ready(function(){
        init();
    });

})(jQuery, window, document);


