import React from 'react'

import './letterwriter.css'
import CKEditor from "react-ckeditor-component";

class Letterwriter extends React.Component{

    constructor(props){
        super(props)
        this.state = {
            letters : this.props.letters,
            active_page : 0
        }
    }
    render(){
        let pages = this.props.letters

        return(<div>
            <page className="A4 position-relative">
                <img className="w-100 position-absolute" src="https://lh6.googleusercontent.com/4cc7kJJVq8KOKLs4glztxYvu1hGg7kVOvUMhrOTeHqHlxCi5I0uieQP1YCRnlswuc1tPgj9VZDWEyCP6a9P6=w1920-h889-rw"/>
                <div className="w-100 letter_editor position-absolute h-100">
                <CKEditor
                    activeClass="p10"
                    inline = {true}
                    config = {
                        {
                            toolbar: []
                        }
                    }
                    />
             </div>
            </page>
        </div>)
    }
}

export default Letterwriter
