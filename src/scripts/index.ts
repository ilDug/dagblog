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

});
