import React from "react"
export const Field=React.forwardRef((props,ref)=>{
    return <div className="form-group"> 
    <textarea ref={ref}
    id="" cols="5"
     rows="5"
      className="form-control" />
 </div> 
} )


