import { Observable } from 'rxjs/Observable';
import  'rxjs/add/observable/fromPromise';
import  'rxjs/add/operator/map';

// const URL_IMAGES :  string = 'http://192.168.0.10:3001/images/posts/';
const URL_IMAGES :  string = 'http://blog.dagtech.it/images/posts/';
// const URL_POPULARS :  string = 'http://192.168.0.10:3001/api/views/';
const URL_POPULARS :  string = 'http://blog.dagtech.it/api/posts/popular/';

export class Popular{

    public template = `
            <a class="cameo-link" href>
                <div class="post-cameo my-3" style="background-image:url(http://lorempixel.com/300/200);"></div>
                <small class="popular-title">title</small>
            </a>
    `;

    private limit:number = 3;
    private domElement : JQuery<HTMLElement>;

    constructor(){

    }





    /** imposta l'elemento segnaposto nel documento */
    public setElement(el:JQuery<HTMLElement>):Popular{
        this.domElement = el;
        return this;
    }




    /** ottinene le visualizzazoni  */
    private get():Observable<any>{
        let posts =  new Promise<any>((resolve, reject)=>{
            $.get(
                URL_POPULARS + this.limit,
                (response)=>{ resolve(response) }
            )
        });

        return Observable.fromPromise(posts);
        // return Observable.fromPromise(posts).map((list:any)=>{ console.log(list); return JSON.parse(list); });
    }




    /**
     * scrive il template nel documento
     */
    private write(template:string):void{
        /**  se non è impostato l'oggetto jquery blocca tutto */
        if(!this.domElement) return;

        /** scrive l'oggetto template */
        this.domElement.html(template);
    }



    /**
     * elabora il json per produrre un template
     */
    private parse(post:any):string{
        if(!post) return;
        let template = '<a class="cameo-link" href="' + post.url + '">';
        template += '<div class="post-cameo my-3" style="background-image:url('+ URL_IMAGES + post.code +'.jpg);"></div>';
        template += '<small class="popular-title">'+ post.title +'</small></a>';

        return template;
    }




    public run(){
        this.get()
            .map( (list:any[])=>{
                return list.map(this.parse).join();
            })
            .subscribe((template: string)=>{ this.write(template); })

    }

}
