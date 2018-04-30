/**
 * controller primario della pagina
 */

import 'bootstrap';
import { Observable } from 'rxjs/Observable';
// import { Likes } from './likes';



/** inizializzazione della pagina */
// $(window).on('load', () => {
    // $("#d-loader").addClass("body-loader-hidden");
    // $("#d-content").removeClass("body-loader-hidden");
// });




$(document).ready(function() {
    console.log('pagina', window.location.href);


    /*++++++++++++ ++++++++ ++++++++++++++++++++++++++++++++++*/
    /*++++++++++++ GENERALI ++++++++++++++++++++++++++++++++++*/
    /*++++++++++++ ++++++++ ++++++++++++++++++++++++++++++++++*/

    /** attiva tutti i tooltip */
    $('[data-toggle="tooltip"]').tooltip()



    /** RICERCA */

    /**
     * attiva il comportamento del bottone search-overlay
     */
    $('#search-overlay-trigger').on('click', (e)=>{
        e.preventDefault();
        $('#search-overlay').addClass('open');
    })






    /**
     * chiude search-overlay
     */
    $('#search-overlay-close').on('click', (e)=>{
        e.preventDefault();
        $('#search-overlay').removeClass('open');
    })


    // let likes = new Likes(10001);
    // $('#likes').html('ciccii');
    // console.log(likes.template)


    /** scroll to top */
    // $(window).scroll(function() {
    //     if ($(this).scrollTop() != 0) {
    //         $(".scrollToTop").fadeIn();
    //     } else {
    //         $(".scrollToTop").fadeOut();
    //     }
    // });
    //
    // $(".scrollToTop").click(function() {
    //     $("body,html").animate({ scrollTop: 0 }, 800);
    // });


});
