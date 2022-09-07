import React from 'react'
import LetterItem from './Letteritem'
class LetterList extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            status : 1
        }
    }
    handlePlusCount(category_id, letter_id){
        console.log('Hello-111')
        let category_index = this.props.categories.findIndex(
            _category =>{
                return _category.category_id == category_id
            }
        );
        let letter_index = this.props.categories[category_index].letters.findIndex(
            _letter =>{
                return _letter.letter_id == letter_id
            }
        );
        let temp = this.props.categories
        temp[category_index].letters[letter_index].count = this.props.categories[category_index].letters[letter_index].count + 1
        console.log("Temp",temp)
        this.props.handleChangeCategories(category_id,1, temp)

    }
    handleMinusCount(category_id, letter_id){
        console.log('Hello-111')
        let category_index = this.props.categories.findIndex(
            _category =>{
                return _category.category_id == category_id
            }
        );
        let letter_index = this.props.categories[category_index].letters.findIndex(
            _letter =>{
                return _letter.letter_id == letter_id
            }
        );
        let temp = this.props.categories
        temp[category_index].letters[letter_index].count = this.props.categories[category_index].letters[letter_index].count - 1
        console.log("Temp",temp)
        this.props.handleChangeCategories(category_id,0,temp)
    }
    render(){
        var categories = this.props.categories;
        var letter_items = [];
        console.log('Track___01', categories)
        categories.forEach(Element => {
            console.log('Tract________',Element != 'undefined')
            if(Element){
                Element.letters.forEach(letteritem => {
                letter_items.push(<LetterItem data = {letteritem} handlePlusCount={() => this.handlePlusCount(letteritem.category_id, letteritem.letter_id)} handleMinusCount={() =>this.handleMinusCount(letteritem.category_id, letteritem.letter_id)}/>)
                })
            }

        })

        return(
            <div className='letter_list_container'>
                {letter_items}
            </div>
        )
    }
}

export default LetterList
