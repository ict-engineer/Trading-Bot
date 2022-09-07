import React from 'react'
import './tabs.css'
class Tabs extends React.Component{
    constructor(props){
        super(props)
    }
    render(){
        return(
            <div className="tabs">
            <input type="radio" id="r2" name="t" /><label htmlFor="r2">Tib</label><div className="content">Article</div>
            <div id="slider" />
          </div>
        )
    }
}

export default Tabs;
