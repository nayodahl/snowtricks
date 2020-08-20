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

console.log("hello jquery");


$('#tricks').on('click', '#load-more', function(e) {
  
    // prevent new page load

    e.preventDefault();
    
    // store next page number

    var next_page = $(this).attr('href');
    
    // remove older posts button from DOM

    //$(this).remove();
    
    // ajax older posts below existing posts

    $('#tricks').append(
        $('<div />').load(next_page + ' #tricks')
    );
});
