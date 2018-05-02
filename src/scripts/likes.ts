import { Cookie } from './cookie';
import { Observable,Subscription } from 'rxjs';


/** nome del cookies che contiene l'array dei post piaciuti */
const LIKES_COOKIE : string = 'postsliked'

// const URL_LIKES :  string = 'https://blog.dagtech.it/views/';
const URL_LIKES :  string = 'http://192.168.0.10:3001/api/likes/';


/**
 * classe che gestisce i like dei posts
 */
export class Likes{

    public template = `
        <span class="mr-3 float-right" data-toggle="tooltip" title="mi piace">
            <a class="mr-1 d-none" href id="likes-unloved"><i class="fal fa-heart fa-2x"></i></a>
            <a class="mr-1 d-none" href id="likes-loved"><i class="fas fa-heart fa-2x"></i></a>
            <span id="like-heart-counter">1</span>
        </span>
    `;

    private domElement : JQuery<HTMLElement>;
    private code: number;
    private likedPosts : number[] = [];


    constructor(code: number){
        this.code = code;

        /** cre l'oggetto cookies */
        let c = new Cookie();

        /** controlla che esita altrimenti lo crea nuovo */
        if(!c.check(LIKES_COOKIE)) { c.set(LIKES_COOKIE, '[]') }


        /** inseisce i risultati nella proprietà della classe */
        this.likedPosts = JSON.parse( c.get(LIKES_COOKIE) );
    }


    /** imposta l'elemento segnaposto nel documento */
    public setElement(el:JQuery<HTMLElement>):Likes{
        this.domElement = el;
        return this;
    }


    /** controlla nei cookiesse c'è il parametro likes */
    private isLoved():boolean{
        let i = this.likedPosts.indexOf(this.code);
        return i > -1;
    }


    public run(){
        /**  se non è impostato l'oggetto jquery blocca tutto */
        if(!this.domElement) return;

        /** scrive l'oggetto template */
        this.domElement.html(this.template).find('[data-toggle="tooltip"]').tooltip();;

        /** imposta lo stato del cuore */
        this.setState();

        /** mette i listener */
        this.domElement.find('#likes-unloved').on('click', (e:any)=>{
            e.preventDefault();
            this.like();
        })
        this.domElement.find('#likes-loved').on('click', (e:any)=>{
            e.preventDefault();
            this.dislike();
        })


        /** ottiene e scrive il numrodi likes */
        this.getLikes().subscribe((likes:number)=>{
            this.domElement.find('#like-heart-counter').text(likes);
        })

    }



    public like():void{
        /** cre l'oggetto cookies */
        let c = new Cookie();

        /** aggiunge il codice alla lista dei piaciuti e scrive la lista nei cookies */
        this.likedPosts.push(this.code);
        this.setState();

        $.post( URL_LIKES , {code:this.code, like: 'like'}, (response)=>{ console.log('liked') }, 'json' );
    }




    public dislike():void{
        /** cre l'oggetto cookies */
        let c = new Cookie();

        /** aggiunge il codice alla lista dei piaciuti e scrive la lista nei cookies */
        let i = this.likedPosts.indexOf(this.code);
        this.likedPosts.splice(i, 1);
        this.setState();

        $.post( URL_LIKES , {code:this.code, like: 'dislike'}, (response)=>{ console.log('disliked') }, 'json' );
    }



    /** imposta il cuore colorato o vuoto in base al parametro */
    private setState(){
        let c = new Cookie();
        c.set( LIKES_COOKIE, JSON.stringify(this.likedPosts) );


        if(this.isLoved()){
            this.domElement.find('#likes-unloved').addClass('d-none');
            this.domElement.find('#likes-loved').removeClass('d-none');
        }else{
            this.domElement.find('#likes-loved').addClass('d-none');
            this.domElement.find('#likes-unloved').removeClass('d-none');
        }
    }




    private getLikes():Observable<number>{
        let likes = new Promise<number>((resolve, reject)=>{
            $.get(
                URL_LIKES + this.code,
                (response)=>{ resolve(response) }
            )
        });
        return Observable.fromPromise(likes);
    }


}
