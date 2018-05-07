/**
 * controller primario della pagina
 */

import 'bootstrap';
// import 'prismjs';
// import 'mathjax/MathJax.js?config=default';
// import { Observable } from 'rxjs/Observable';
import { Likes } from './likes';
import { Views } from './views';
import { Popular } from './populars';

// <script type="text/javascript" src="path-to-MathJax/MathJax.js?config=default"></script>



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



    /**
     * per ogni link nel post sceglie quelli esterni e li a pre in una nuova scheda
     */
    $('.post a').each((i, el)=>{
        let href = $(el).attr('href').substr(0,4);
        if(/http/.test(href)) $(el).attr('target', '_blank');
    });


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




    /**
     * carica i post popolari
     */
    let populars = new Popular();
    let popoularsElement = $('#popular-wrapper');
    populars.setElement(popoularsElement).run();



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
