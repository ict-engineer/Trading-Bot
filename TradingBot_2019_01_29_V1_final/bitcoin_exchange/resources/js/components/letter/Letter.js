import React from 'react'
import LetterCategoryList from './categories/LetterCategoryList'
import LetterList from './LetterList'
import './letters.css'
class Letter extends React.Component{

    constructor(props){
        super(props)
        this.state = {
            letter_categories : this.props.categories,
            selected_category : null
        }
        this.resetCategoryHandler = this.resetCategoryHandler.bind(this)
        this.selectCategoryHandler = this.selectCategoryHandler.bind(this)
        this.handleChangeCategories = this.handleChangeCategories.bind(this)
    }
    resetCategoryHandler(e){
        e.preventDefault();
        this.setState({
            selected_category : null
        })
    }
    selectCategoryHandler(e){
        e.preventDefault();
        this.setState({
            selected_category : e.target.name
        })
    }
    handleChangeCategories(_category_id,option, _state){
        console.log(_category_id, _state)
        this.props.handleChangeStateCategories(_category_id, option , _state)
    }

    render(){
        console.log('Selected_category', this.state.selected_category)
        var selected_category = [];
        console.log('Categories',this.props.categories)
        if(this.state.selected_category == null){

            this.props.categories.forEach(Element=>{
                selected_category.push(Element)
            })
        }
        else{
            var _category = null
            let letter_index = this.props.categories.findIndex(
                _category =>{
                    console.log('checking', _category.category_id, this.state.selected_category, _category.category_id == this.state.selected_category)
                    return _category.category_id == this.state.selected_category
                }
            );
            console.log('letter_index', letter_index)
            if(letter_index != -1) selected_category.push(this.props.categories[letter_index])
        }

        return (
            <div>
                <LetterCategoryList categories = {this.state.letter_categories} resetHandler = {this.resetCategoryHandler} clickCategoryHandler = {this.selectCategoryHandler} active_category = {this.state.selected_category}/>
                <LetterList categories = {selected_category} handleChangeCategories = {this.handleChangeCategories}  />
            </div>
        )
    }
}

export default Letter;
