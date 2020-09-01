
jQuery(document).ready(function() {
    var $wrapper = $('.js-trick-image-wrapper');
    $wrapper.on('click', '.js-remove-image', function(e) {
        e.preventDefault();
        $(this).closest('.js-trick-image-item')
            .fadeOut()
            .remove();
    });
});

jQuery(document).ready(function() {
    // Get the div that holds the collection of tags
    var $wrapper = $('.js-trick-video-wrapper');

    $wrapper.on('click', '.js-trick-video-add', function(e) {
        e.preventDefault();

        var prototype = $wrapper.data('prototype');
        var index = $wrapper.data('index');

        // Replace '__name__' in the prototype's HTML to
        // instead be a number based on how many items we have
        var newForm = prototype.replace(/__name__/g, index);

        // increase the index with one for the next item
        $wrapper.data('index', index + 1);

        // Display the form in the page before the "new" link
        $(this).before(newForm);
    })
});

jQuery(document).ready(function() {
    var $wrapper = $('.js-trick-video-wrapper');
    $wrapper.on('click', '.js-remove-video', function(e) {
        e.preventDefault();
        $(this).closest('.js-trick-video-item')
            .fadeOut()
            .remove();
    });
});