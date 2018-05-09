import { Cookie } from './cookie';
import { Observable } from 'rxjs/Observable';
import  'rxjs/add/observable/fromPromise';
import  'rxjs/add/operator/switchMap';
import  'rxjs/add/operator/do';

const URL_VIEWS :  string = 'http://blog.dagtech.it/api/views/';
// const URL_VIEWS :  string = 'http://192.168.0.10:3001/api/views/';

/** nome del cookies che contiene l'array dei post visualizzati */
const VIEWS_COOKIE : string = 'postsviewed'

export class Views{

    public template = `
        <span class="ml-3" data-toggle="tooltip" title="visualizzazioni">
        <i class="fal fa-asterisk mr-1"></i>
            <span id="views-counter">n/d</span>
        </span>
    `;


    public code: number;
    private domElement : JQuery<HTMLElement>;
    private viewedposts : number[] = [];

    constructor(code:number){
        this.code = code;

        /** cre l'oggetto cookies */
        let c = new Cookie();


        /** controlla che esita altrimenti lo crea nuovo */
        if(!c.check(VIEWS_COOKIE)) { c.set(VIEWS_COOKIE, '[]', 365, '/') }


        /** inseisce i risultati nella proprietà della classe */
        this.viewedposts = JSON.parse( c.get(VIEWS_COOKIE) );
    }





    /** imposta l'elemento segnaposto nel documento */
    public setElement(el:JQuery<HTMLElement>):Views{
        this.domElement = el;
        return this;
    }


    /** controlla nei cookies se c'è il codice per quesa pagina */
    private isViewed():boolean{
        let i = this.viewedposts.indexOf(this.code);
        console.log(i, this.code, this.viewedposts)
        return i > -1;
    }



    /** ottinene le visualizzazoni  */
    private get(code: number):Observable<number>{
        let views =  new Promise<number>((resolve, reject)=>{
            $.get(
                URL_VIEWS + this.code,
                (response)=>{ resolve(response) }
            )
        });

        return Observable.fromPromise(views);
    }






    /** aumenta la visualizzazione nel database */
    private add(code: number):Observable<boolean>{
        let views = new Promise<boolean>((resolve, reject)=>{
            $.post(
                URL_VIEWS,
                {code:code},
                (response)=>{ resolve(response) },
                'json'
            )
        });
        return Observable.fromPromise(views)
    }






    /**
     * scrive il template nel documento
     */
    private write(views:number):void{
        /**  se non è impostato l'oggetto jquery blocca tutto */
        if(!this.domElement) return;

        /** scrive l'oggetto template */
        this.domElement.html(this.template).find('#views-counter').text(views);
        this.domElement.find('[data-toggle="tooltip"]').tooltip();
    }





    public run(){
        if(this.isViewed()){
            /** se la paginaè già stata vista */
            this.get(this.code)
                .subscribe((views: number)=>{ this.write(views); })
        }else{
            /** se la pagina non è mai stata vista  */
            this.add(this.code)
                .do(()=>{
                    this.viewedposts.push(this.code);
                    /** aggiunge il cookies */
                    let c = new Cookie();
                    c.set( VIEWS_COOKIE, JSON.stringify(this.viewedposts), 365, '/');
                })
                .switchMap((x)=>{ return this.get(this.code) })
                .subscribe((views: number)=>{ this.write(views); })
        }


    }

}
