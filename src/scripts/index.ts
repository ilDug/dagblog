/**
 * controller primario della pagina
 */

import 'bootstrap';
import { Observable } from 'rxjs/Observable';


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


});
