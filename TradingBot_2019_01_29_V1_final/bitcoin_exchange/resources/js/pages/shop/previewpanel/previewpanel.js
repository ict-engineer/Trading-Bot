import React from 'react'
import './previewpanel.css'
class PreviewPanel extends React.Component{
    constructor(props){
        super(props)
        //console.log('____________',this.props)
        this.state = {
            data : this.props.data
        }
    }
    render(){
        //console.log('_preview_', this.state)

        var cart_envelope_name = this.state.data.cartEnvelope.envelope_name || 'empty'
        var percent = 0;
        if(this.state.data.cartEnvelope.envelope_name){
            percent = 25;
        }

        var TotalPrice = 0;
        var cart_envelope_info = <span></span>
        var cart_letter_info = []

        if(this.state.data.cartEnvelope.envelope_name){
            if( this.state.data.cartLetter.length){
                percent = 50;

            }
            var progressbar_style = {
                width : percent + '%'
            }

            cart_envelope_info = <span style={ {color : 'blue', fontWeight : 'bolder'}}>{this.state.data.cartEnvelope.envelope_name} - {this.state.data.cartEnvelope.envelope_price} $</span>
            TotalPrice += parseFloat(this.state.data.cartEnvelope.envelope_price)
            this.state.data.cartLetter.forEach(letter => {
                TotalPrice += parseFloat(letter.letter_price) * parseFloat(letter.count)
                cart_letter_info.push(
                    <span style={ {color : 'blue', fontWeight : 'bolder'}}>{letter.letter_title}({letter.count} Paper) - {parseFloat(letter.letter_price) * parseFloat(letter.count)} $</span>
                )
                cart_letter_info.push(<br></br>)
            });
        }
        return(

        <div className="edit-pane-inner full-height flex">

        <div className="product-crumb paddings half  stroke-top no-small-medium">
            <h6 className="lowercase type-book">
            <a className="light-grey" href="/collections">shop</a>
            <span className="sep-slash light-grey" />
            <a className="dark-grey" href="/collections#build-your-box">Build Your Box</a>
            </h6>
        </div>
      <div className="product-title no-small-medium">
        <h2>Build Your Box</h2>
        <div className="pretty-select selectric-valid" id="pretty-select-box-size-select" data-name>

        </div>
        <div className="divider quarter" />
      </div>

      <div className="product-body">
        <div className="product-count">
          <div className="count-head flex-space-between">
            <div className="count-amount flex-space-between">
              <h4 className="lowercase line-large">In Your Box</h4>
              <h6 className="type-book dark-grey">
                <span className="box-counter js-box-counter">0</span>
                / 18
              </h6>
            </div>
            <a className="close-edit-pane js-close-edit-pane mid-grey no-large-up" href="javascript:void(0);">
              <span className="icon-x-close" />
            </a>
          </div>
        </div>
        <div className="builder-items-wrap">
          <div className="items-outer">
            <div className="builder-items js-builder-items" />
            <div className="guides">
              <div className="items-divider-h-1" />
              <div className="items-divider-h-2" />
              <div className="items-divider-v-1" />
              <div className="items-divider-v-2" />
              <div className="items-divider-v-3" />
              <div className="items-divider-v-4" />
              <div className="items-divider-v-5" />
            </div>
            <div className="guide-boxes flex-row collapse">
            {cart_envelope_info}
            <br></br>
            {cart_letter_info}
              {/* <div className="guide-box">
                <div className="box-inner" style={{backgroundImage: "url(" +  this.state.data.cartEnvelope.envelope_image  + ")" ,     backgroundPosition: 'center',

backgroundSize: 'contain',
backgroundRepeat: 'no-repeat'}}>
                  <span className="box-num">{this.state.data.cartEnvelope.envelope_price + '$'} </span>
                </div>
              </div> */}

            </div>
          </div>
        </div>
      </div>
      <div style={{ textAlign : 'right' }}>Total Price : {TotalPrice} $</div>

            <div className="progress">
                <div className="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style={progressbar_style}></div>
            </div>
        </div>
        )
    }
}

export default PreviewPanel;
