import React from 'react'

class LetterItem extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            count : 0
        }
        this.onclickHandler = this.onclickHandler.bind(this)
        this.handlePlusCount = this.handlePlusCount.bind(this)
        this.handleMinusCount = this.handleMinusCount.bind(this)
    }
    onclickHandler(e)
    {
        e.preventDefault();

    }
    handlePlusCount(e){
        // e.preventDefault();
        console.log('Hello')


        this.props.handlePlusCount
    }
    handleMinusCount(e){
        // e.preventDefault();
        console.log('Hello-Minus')
        if(this.props.data.count > 0){

            this.props.handlePlusCount
        }

    }
    render(){
        console.log('letter_items',this.props.data.letter_template)
        return(
            <div className='letteritem' onClick={this.onclickHandler}>
            <div className="paper_counter" data-counter={this.props.data.count}>{this.props.data.count}</div>
            <img src={this.props.data.letter_template}/>
            <h4 className="text-bold">{this.props.data.letter_title}</h4>
            <h6>{this.props.data.letter_price} $ </h6>
                <div>
                    <button onClick={this.props.handlePlusCount}><i className="fa fa-plus"></i></button>
                    <button onClick={this.props.handleMinusCount}><i className="fa fa-minus"></i></button>
                </div>
            </div>
        )
    }
}
function mapStateToProps(state){
    return {
        count : this.state.count
    }
}

export default LetterItem
