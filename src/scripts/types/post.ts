/**
 * classe che descive la struttura del POST
 */
export class Post{
    /** codice univoco dell'articolo */
    public code : number;

    /** date  */
    public date: { creation : Date,  update: Date }

    public title: string;

    public url: string;

    public related: string[];

    public score: number;

    public priority: number;

    public fixed : boolean;

    public filename : string;

    public tag: { [tag:string]: Tag };


    constructor(p:any){
        this.code =  p.code ? p.code : null;
        this.date =  p.date ? p.date : { creation : null,  update: null };
        this.title =  p.title ? p.title : null;
        this.url =  p.url ? p.url : null;
        this.related =  p.related ? p.related : [];
        this.score =  p.score ? p.score : 0;
        this.priority =  p.priority ? p.priority : 0;
        this.fixed =  p.fixed != null ? p.fixed : false;
        this.filename =  p.filename ? p.filename : null;
        this.tag =  p.tag ? p.tag : null;
    }


}



export class Tag{
    public category: boolean;

    public label: boolean;

    public tag: boolean;

    constructor(){}


}
