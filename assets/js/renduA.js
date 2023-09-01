import { render } from "react-dom";
import React from "react";
import { Oeuvress } from "./pageAccueil.js";
import  ReactDOM from "react-dom";
// import {createRoot} from 'react-dom/client'
// const container=document.getElementById('root');
// const root = ReactDOM.createRoot(container)
// root.render(<Tableau />);
 

console.log('fggdg')
// const reqSvgs = require.context ('./images', true )

// const svgs = reqSvgs
//   .keys ()
//   .reduce ( ( images, path ) => {
//     images[path] = reqSvgs ( path )
//     return images
//   }, {} )





function Tableau(){
    
const{items,load}=Oeuvress('/api/oeuvres')

return(
   

    <div className ="imageHome">
        {load}
     {/* {JSON.stringify(items) }  */}
     {items && items.map((item,index)=>{
            return(
               
                <div key={index} className="imgTitre" >

                <div className='img'>
             

                    
                    <img src={ item.image}
                 className="imgHome" />
                  
                  </div>
                {/* <div>{item.name} </div> */}
                
                 
                
                <div>{item.titre} </div>
                {/* <div>{item.image} </div> */}

                {/* <button>ajouter</button> */}

                </div>
              
                
                    
                
               
            )
        } )}
     
     {/* {items.map(c=><Affichage key={c.id} affichage={c}/>)} */}
     </div>
    )
}

function Affichage(affichage){
    return(
        <>
         <div className="">
            <h4>
                {affichage .titre}
            </h4>
            <div>
                {affichage.image}
            </div>
        </div> 
            
        </>
    )
}




class TabElement extends HTMLElement{
    connectedCallback(){
       render(<Tableau/>,this)
    
}}
customElements.define('post-comments',TabElement )

console.log(Tableau)




    