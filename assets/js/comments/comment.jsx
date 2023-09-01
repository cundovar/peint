import { render } from "react-dom"
import React, { useCallback, useEffect, useRef} from "react"
import {   UseUrl,  useFetch } from "./hooks"




const dateFormat={
    dateStyle:'medium',
    timeStyle :"short"
}
// prend deux proprité user et post
function Comments({post,user}){

    const {items:comments,load,loading,setItems:setComments,count,setCount,hasMore}=UseUrl('/api/commentaires?oeuvre='+ post)
    // ajoute commentaire 
    const addComment=useCallback(comment=>{
        setComments(comments=>[comment, ...comments]);
        setCount(count => count + 1)
    },[])
    useEffect(()=>{
        load()
    },[])
    return <div>
        {loading && 'Chargement...'}
        <Title count={count}/>
        { user && <CommentForm post={post}  onComment={addComment} />}
        {comments.map(comment=><Comment key={comment.id} comment={comment}/>)}
        {hasMore && <button className="btn btn-primary"onClick={load} >charger plus de commentaire</button>}
    </div>
}

const Comment=React.memo(({comment})=>{
    const date=new Date(comment.dateAt)
    return <div className="row post-comment">
        <h5 className="col-sm-3">
        <strong>    {comment.user.prenom} </strong>
            a commenté le {date.toLocaleString(undefined, dateFormat)} 
        </h5>
        <div className="clo-sm-9">
            <p>{ comment.comment} </p>
        </div>

    </div>
})

const CommentForm= React.memo(({post,onComment})=>{
    const ref=useRef(null)

    const onSuccess=useCallback(commentaire=>{
        /*  function onSuccess(commentaire) {
        onComment(commentaire);
        ref.current.value = '';
      } */
       onComment(commentaire);
       ref.current.value='';
    },[ref,onComment])

     const {load2,loading}= useFetch('/api/commentaires','POST',onSuccess)
     console.log({load2})

     const onSubmit=useCallback(e=>{
        const commentDate = new Date()
        e.preventDefault()
        //envoi à l'api
        load2({
            comment:ref.current.value,
            oeuvre:"/api/oeuvres/"+post,
            dateAt: commentDate.toISOString(dateFormat)
        })
     },[ref,post])
   
    
     console.log(ref)
    return   <div className="well">
    <form onSubmit={onSubmit}>    
        <fieldset>
            <legend>laisser un commentaire</legend> 
   </fieldset> 
       <div className="form-group"> 
           <textarea ref={ref} 
          cols="5"
            rows="5"
             className="form-control" />
        </div> 
        <div className="form-group"> 
            <button className="btn btn-primary" disabled={loading}>envoyer</button> 
        </div> 
    </form> 
</div> 
    
   
   
   
   
   
})

function Title({count}){
    return <h4 >
  
        {count} Commentaire{count> 1 ? 's':''} </h4>
}

class CommentsElement extends HTMLElement{
    connectedCallback(){
        const post = parseInt(this.dataset.post,10)
        const user = parseInt(this.dataset.user,10) || null
        render (<Comments post={post} user={user} />,this)    
    }

}
customElements.define('comments-show',CommentsElement)


















