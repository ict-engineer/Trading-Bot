import React from 'react'
import FilterButton from './FilterButton'
import './category.css'
class LetterCategoryList extends React.Component{
    constructor(props)
    {
        super(props)
        this.state = {
            categories : this.props.categories
        }
        this.handleFilter = this.handleFilter.bind(this)
    }
    handleFilter(){

    }

    render(){
        console.log(this.props.categories)
        var category_list_buttons = [];
        category_list_buttons.push(
            <a onClick={this.props.resetHandler} name="all" className={ this.props.active_category ? 'btn_letter_category' : 'btn_letter_category active' }>All</a>
        )
        this.props.categories.forEach(element => {
            category_list_buttons.push(<a  className={ this.props.active_category == element.category_id ? 'btn_letter_category active' : 'btn_letter_category ' } onClick={this.props.clickCategoryHandler} name={element.category_id}>{element.category_name}</a>)
        });
        return(
            <div className='category_buttons_container'>
                {category_list_buttons}
            </div>
        )
    }
}


export default LetterCategoryList;
