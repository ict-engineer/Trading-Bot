import React from 'react'

class Envelope extends React.Component{
    constructor (props){
        super(props)

        this.state =  {
            is_modal_open : false
        }
        //console.log('______________________',this.state)
        this.handleAddToCart = this.handleAddToCart.bind(this)
        this.handleShowModal = this.handleShowModal.bind(this)
    }
    handleAddToCart(e){
        e.preventDefault();
        var envelope_data = this.props.data

        var is_selected = envelope_data.is_selected ? false : true
        envelope_data.is_selected =  is_selected


        this.props.callbackCartHandler(envelope_data)

    }
    handleShowModal(e){
        e.preventDefault();
         let {is_modal_open} = this.state;
         this.setState(
             {
                is_modal_open : !is_modal_open
             }
         )
    }
    render(){
        let {is_modal_open} = this.state;
        let modal_style = {
           display : 'none'
        }
        if(is_modal_open){
            modal_style = {
                display : 'block'
             }
        }

        return(

      <div className="single-card js-single-card  " data-product-type="socks" data-product-id={1475936616531} data-tags="color_grey cut_spotlight pattern_aztec " data-product-handle="aztec-stripe-grey-red-black" data-index={21} data-in-stock={1090} data-size-text data-in-box={0} data-variant-id={13538379694163} data-count={1}>
      <div className="single-card-ui js-single-card-ui"  >
        <div className="count-modifiers js-count-modifiers">
          <div className="item-qty-count h6 js-item-qty-count" />
          <a className="h6 delete-item js-delete-item" href="javascript:void(0);">
            <span className="bots">Delete</span>
            –
          </a>
        </div>
        <div className="ui-inner "   >

          <div className="single-img"  >
            <div className="lazy js-lazy square-img lazy-loaded">
              <img className="lazy-img lazy-preload lazyautosizes lazy-loaded" src={this.props.data.envelope_image} data-src={this.props.data.envelope_image} data-srcset={this.props.data.envelope_image} data-sizes="auto" sizes="127px" srcSet={this.props.data.envelope_image} />
              <div className="loader" />
              <img className="fallback" src={this.props.data.envelope_image}  />
            </div>
          </div>
        <div className="border" onClick={this.handleShowModal}/>

          <div className="add-to-box js-add-to-box">
            <h6 className="lowercase">
              <span className="text-add" onClick={this.handleAddToCart}>{this.props.data.is_selected ? 'Remove From Cart' : 'Add to Cart' }</span>
              <span className="text-add-another" onClick={this.handleAddToCart}>
                  {this.props.data.is_selected ? 'Remove From Cart' : 'Add to Cart' }</span>
              <span className="text-out-of-stock">Out of Stock</span>
              <span className="text-select-size">Select Size</span>
            </h6>
          </div>
        </div>
      </div>
      {/* / Mini Card */}
      <div className="mini-single-card js-mini-single-card " data-product-id={1475936616531} data-variant-id data-count={1}>
        <div className="mini-single-card-inner">
          <div className="single-content">
            <div className="mini-img">
              <div className="lazy js-lazy lazy-img bg-img lazy-loade">
                <div className="lazy-img js-lazy-img bg-img " data-bgset={this.props.data.envelope_image} data-src={this.props.data.envelope_image} style={{backgroundImage: "url(" +  this.props.data.envelope_image  + ")" }} data-sizes="auto" />
                <div className="loader" />
                <div className="fallback bg-img"  />
              </div>
            </div>
          </div>
          <div className="remove-icon" onClick={this.handleShowModal}>
            <span className="icon-x-close" />
            <span className="bots" />
          </div>
        </div>
      </div>
      {/* / Zoom View */}
      <div className="zoom-single-card js-zoom-single-card" data-id={1475936616531} style={modal_style}>
        <div className="panel-overlay" />
        <div className="zoom-card-ui">
          <div className="zoom-card-ui-inner">
            <div className="zoom-img">
              <div className="lazy js-lazy ">
                <div className="lazy-img js-lazy-img bg-img " data-bgset={this.props.data.envelope_image} data-src={this.props.data.envelope_image} data-sizes="auto" />
                <div className="loader" />
                <div className="fallback bg-img" style={{backgroundImage: "url(" +  this.props.data.envelope_image  + ")" }} />
              </div>
            </div>
            <div className="zoom-content">
              <div className="content-inner flex full-height" style={{backgroundImage: "url(" +  this.props.data.envelope_image  + ")" ,     backgroundPosition: 'center',

    backgroundSize: 'contain',
    backgroundRepeat: 'no-repeat'}}>
                <div className="top-content has-absolute">
                  <div className="title-wrap bottom-margin half line-medium lowercase">
                    <h4>
                     {this.props.data.category_name}
                    </h4>
                    <h5 className="light-grey">
                      {this.props.data.envelope_name}
                    </h5>
                    <p>&nbsp;</p>
                  </div>
                  <a className="close-icon light-grey js-close-zoom" onClick={this.handleShowModal}>
                    <span className="icon-x-close" />
                    <span className="bots">close</span>
                  </a>
                </div>
                <div className="bottom-content">
                  <button className="button-cta zoom-add-to-box js-zoom-add-to-box" onClick={this.handleAddToCart}>
                  {this.props.data.is_selected ? 'Remove From Cart' : 'Add to Cart' }
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
            // <div className='col-md-2 envelope'>
            //         <div className='backdrop h-100'>
            //             <span className='btn_preview_envelope' onClick={this.handleShowModal}><i className='fa fa-eye'></i></span>
            //             <button className='btn_cart' onClick={this.handleAddToCart} >{this.props.data.is_selected ? 'Remove From Cart' : 'Add to Cart' }</button>

            //         </div>
            //         <img src={this.props.data.envelope_image}/>

            // </div>
        )
    }
}
export default Envelope;
