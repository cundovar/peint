let zone = document.getElementById('zone');
     

function loadFile(event)
{
    console.log("test");

    $('#zone').html("");
   let image = document.createElement("img");
   image.setAttribute("src", URL.createObjectURL(event.target.files[0]) );
   image.setAttribute("class", "img300" );

    zone.append(image);



}

// ***********modal***********

window.onload=()=>{
  const modalButtons=document.querySelectorAll("[data-toggle=modal]");
   for (let button of modalButtons){
    button.addEventListener("click",function(e){
         //on empeche la navigation
         e.preventDefault();
         //on recupère le target
         let target = this.dataset.target;
         //on recupère la bonne modal
         let modal=document.querySelector(target);
         modal.classList.add("show")
         
         console.log(target)
        });
        console.log(modalButtons)
        
}
}


  const modalnav=document.querySelectorAll("[data-toggle=modalNav]");
   for (let button of modalnav){
    button.addEventListener("click",function(e){
         //on empeche la navigation
         e.preventDefault();
         //on recupère le target
         let target= this.dataset.target;
         //on recupère la bonne modal
         let menu_burger=document.querySelector(target);
         menu_burger.classList.add("showmenu")
         
         
        });
          //  document.body.addEventListener("click", function(){
     
          //   this.remove.showmenu
          // })
      
        
      }
      
      // document.body.addEventListener("click", function(e){
        //   e.preventDefault();
        //     this.classList.remove("showmenu")
        //   })
        
        
        // document.body.addEventListener("click", function (ev) {
        //   if (ev.target === menu_burger) {
            
            
            
        //     menu_burger.style.visibility="visible";
        //   }
      
        //   if (ev.target !==menu_burger ) {
        //     menu_burger.style.visibility="hidden";
        //   }
  
          
        // });
       
        

// // on gère les bouton de fermuture
// const modalClose=modal.querySelectorAll("[data-dismiss=filter]")
// console.log(modalClose)
// for(let close of modalClose){
//   close.addEventListener("click",()=>{
//     modal.classList.remove("show")

  // })
// }
// ON GèRE LA FERMEURE ZONE grise
// modal.addEventListener("click", function(){
//   this.classList.remove.show
// });
// on evite propagation du click d'un enfant a son parent/

// modal.children[0].addEventListener("click",function(e){
//   e.stopPropagation()
// })






// loupe
// function prepar(){
//   zoom=3;
//   largeur=200
//   dimensionLoupe=120
//   document.getElementById('imgShow').width=largeur
//   document.getElementById('loupe').style.width= dimensionLoupe
//   document.getElementById('loupe').style.height= dimensionLoupe
//   document.getElementById('imgLoupe').width=zoom*largeur
// }

zoom=5;
const louper=document.querySelector('#imgShow')

louper.onmousemove=function(){
  let loupe=document.getElementById("loupe");
  
 let imgLoupe=document.getElementById('imgLoupe')
 loupe.style.top=event.clientY -300 + "px";
  loupe.style.left=event.clientX -550+"px";
  imgLoupe.style.width=500*zoom + "px";
  // imgLoupe.style.height=auto*zoom + "px";
  imgLoupe.style.top=(-event.clientY*zoom)+1000+"px"
  imgLoupe.style.left=(-event.clientX*zoom)+2500+"px"
  //  imgLoupe.style= (-imgLoupe.offsetTop*zoom)+300 +"px"
 

}


// desative hover ecran tactile
//code copier
//https://stackoverflow.com/questions/23885255/how-to-remove-ignore-hover-css-style-on-touch-devices
function watchForHover() {
  
    let lastTouchTime = 0
  
    function enableHover() {
      if (new Date() - lastTouchTime < 500) return
      document.body.classList.add('hasHover')
    }
  
    function disableHover() {
      document.body.classList.remove('hasHover')
    }
  
    function updateLastTouchTime() {
      lastTouchTime = new Date()
    }
  
    document.addEventListener('touchstart', updateLastTouchTime, true)
    document.addEventListener('touchstart', disableHover, true)
    document.addEventListener('mousemove', enableHover, true)
  
    enableHover()
  }
  
  watchForHover()


 
  console.log('fdgdgdh')