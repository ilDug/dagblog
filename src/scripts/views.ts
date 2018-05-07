import { Observable } from 'rxjs/Observable';
import  'rxjs/add/observable/fromPromise';
import  'rxjs/add/operator/switchMap';

const URL_VIEWS :  string = 'http://blog.dagtech.it/api/views/';
// const URL_VIEWS :  string = 'http://192.168.0.10:3001/api/views/';

export class Views{

    public template = `
        <span class="ml-3" data-toggle="tooltip" title="visualizzazioni">
        <i class="fal fa-asterisk mr-1"></i>
            <span id="views-counter">n/d</span>
        </span>
    `;


    public code: number;
    private domElement : JQuery<HTMLElement>;

    constructor(code:number){
        this.code = code;
    }





    /** imposta l'elemento segnaposto nel documento */
    public setElement(el:JQuery<HTMLElement>):Views{
        this.domElement = el;
        return this;
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
        this.add(this.code).switchMap((x)=>{ return this.get(this.code) })
            .subscribe((views: number)=>{ this.write(views); })

    }

}
