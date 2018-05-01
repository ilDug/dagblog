/**
 * controller primario della pagina
 */

import 'bootstrap';
import { Observable } from 'rxjs/Observable';
import { Likes } from './likes';
import { Views } from './views';



/** inizializzazione della pagina */
// $(window).on('load', () => {
    // $("#d-loader").addClass("body-loader-hidden");
    // $("#d-content").removeClass("body-loader-hidden");
// });




$(document).ready(function() {
    console.log('pagina', window.location.href);
    console.log('location', window.location.pathname.split('/'));
    const _code: number = +window.location.pathname.split('/')[1] ;

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



    /**
     * imposta i likes
     */
    let likes = new Likes(_code);
    let likeElement = $('#likes');
    likes.setElement(likeElement).run();



    //imposta le visualizzazioni
    let views = new Views(_code);
    let viewsElement = $('#views');
    views.setElement(viewsElement).run();

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
