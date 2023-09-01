

import {useState,useEffect, useCallback} from 'react';
import axios from 'axios';
// import ReactDOM from 'react-dom/client';
import  ReactDOM  from 'react';
import { render } from 'react-dom';
import {createRoot} from 'react'
// import {createRoot} from 'react-dom/client';





export function Oeuvress(url){
  

    const [items, setItems]=useState([])

    const load=useEffect(async () => {     
     const data = await fetch(url,{
         headers:{
             'Accept':'application/ld+json'
         }
     } )
     const dataResponse=await data.json()

     if (data.ok){
     setItems(dataResponse[`hydra:member`] )
     }
     else{
     console.error(dataResponse )
           }

},[url])
return{
items,
load,


// console.log(items),

}

}


    

    

    
    
    
    
    // return(
    //     <>
       
    //     <h1> Page Article</h1>
       
      
       
       
    //     {JSON.stringify(oeuvre)}
    //     {oeuvre && oeuvre.map((item,index)=>{
    //         return(
    //             <div key={index} className="article" >

    //             <div className='img'><img src={ item.picture} className="img" /> </div>
    //             <div>{item.name} </div>
                

                
    //             <div>{item.description} </div>
    //             <div>{item.price} €</div>

    //             <button>ajouter</button>

    //             </div>
              
                
                    
                
               
    //         )
    //     } 
    //     )}
      
    
        
    //     </>
    // )

