import React from 'react'

class EnvelopeModal extends React.Component{
    constructor (props){
        super(props)
        //console.log(this.props)

        this.state =  this.props.data
        this.handleAddToCart = this.handleAddToCart.bind(this)
        this.handleCloseModal = this.handleCloseModal.bind(this)
    }
    handleAddToCart(e){
        e.preventDefault();
        var envelope_data = this.props.data
        var is_selected = envelope_data.is_selected ? false : true
        envelope_data.is_selected =  is_selected

        this.props.callbackCartHandler(envelope_data)
    }

    handleCloseModal(e){
        e.preventDefault();
        let envelope_data = this.props.data
        envelope_data.open_status = false
        this.props.callbackCartHandler(envelope_data, true)
    }
    render(){

        var envelop_open_status = this.props.data.open_status ? 'open' : 'closed';
        return(
            <div className={'envelope_modal ' + envelop_open_status} >
                    <div className='envelope_modal_backdrop'></div>
                    <div className='envelope_modal_dialog'>
                        <div className='header'>
                            <div className='title'>
                                <h1>{this.props.data.envelope_name}</h1>
                                <small>{this.props.data.category_name}</small>
                            </div>
                            <button className='btn_close_envelope_modal' onClick={this.handleCloseModal}><i className='fa fa-close'></i></button>
                        </div>
                        <div className='body'>
                            <img src={this.props.data.envelope_image}/>
                            <div className='price'>{this.props.data.envelope_price}</div>
                        </div>
                        <div className='footer'>
                        <button className='btn_cart' onClick={this.handleAddToCart} >{this.props.data.is_selected ? 'Remove From Cart' : 'Add to Cart' }</button>

                        </div>
                    </div>

            </div>
        )
    }
}
export default EnvelopeModal;
