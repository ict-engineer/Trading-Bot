import React from 'react';
import Wizard from './wizard/Wizard'
import CartPanel from './cartpanel/cartpanel'
import PreviewPanel from './previewpanel/previewpanel'

import './shop.css'
class Shop extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            cartItems : {
                cartEnvelope : {},
                cartLetter : []
            }
        }
        this.handleCart = this.handleCart.bind(this)
    }
    handleCart(data){
        var cartItems = this.state.cartItems;
        cartItems.cartEnvelope = data;
        this.setState({
            cartItems : cartItems
        })

    }
    handleCartLetter(data){
        var cartItems = this.state.cartItems;
        cartItems.cartLetter = data;
        this.setState({
            cartItems : cartItems
        })
    }
    render(){
        // //console.log('_preview_render_', this.state.cartItems.cartEnvelope)

        return (
            <div className='flex-row has-absolute' id="product-main">
                <div className='builder-wrap small-12 large-8 xlarge-9 flex-columns'>
                    <Wizard handleCart = {this.handleCart.bind(this)} handleCartLetter={this.handleCartLetter.bind(this)} cartedLetter = {this.state.cartItems.cartLetter}/>
                </div>
                <div className='edit-pane js-edit-pane small-12 large-4 xlarge-3 flex-columns'>
                    <PreviewPanel data = {this.state.cartItems}/>
                </div>
            </div>
        )
    }
}

export default Shop;
