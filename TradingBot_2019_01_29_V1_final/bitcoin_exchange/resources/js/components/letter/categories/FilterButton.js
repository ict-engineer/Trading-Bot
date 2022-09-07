import React from 'react'

class FilterButton extends  React.Component{
    constructor(props){
        super(props)
        this.setState = this.props.data
    }
    render(){

        return (
			<a onClick={this.props.onClick}>{this.props.data.category_name}</a>

		)
    }
}

export default FilterButton;
