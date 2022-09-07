import React from 'react'

class Tab extends React.Component{
    constructor(props){
        super(props)

    }
    render(){
        return(
            <input type="radio" id="r1" name="t" defaultChecked /><label htmlFor="r1">Tab</label><div className="content">Content</div>

        )
    }
}
export default Tab;
