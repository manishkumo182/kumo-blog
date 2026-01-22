(function( $ ) {
    $(function() {
        var container = document.querySelector('.js-masonry');
        var msnry;
        imagesLoaded( container, function() {
            msnry = new Masonry( container, {
                itemSelector: '.item-masonry',
                isFitWidth: true
            });
        });
    });
});