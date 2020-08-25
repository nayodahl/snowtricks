/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';
import '../css/animate.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
import 'bootstrap'; // adds functions to jQuery

console.log("hello page trick");

jQuery(document).ready(function() {
    // Get the div that holds the collection of tags
    var $wrapper = $('.js-trick-image-wrapper');

    $wrapper.on('click', '.js-trick-image-add', function(e) {
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