import React from 'react'
import './envelopelist.css'
import Envelope from './item/Envelope'
import EnvelopeModal from './item/EnvelopeModal'
class EnvelopeList extends React.Component{

    constructor(props){
        super(props);
        this.state = {
            current_selected_category : this.props.current_selected_category,
            current_selected_envelope : this.props.current_selected_envelope,
            cateogories : this.props.data
        }


        this.handleCart = this.handleCart.bind(this)
    }
    handleCart(_state , option = false){
        //console.log('_+++++ClickEvent++++++_',_state,this.props.data )
        let category_index = this.props.data.findIndex(
            _category => _category.category_id === _state.category_id
        );
        let SelectedCategory = this.props.data[category_index];
        //console.log(SelectedCategory.envelopes)
        let envelope_index = SelectedCategory.envelopes.findIndex(
            _envelope => _envelope.envelope_id  === _state.envelope_id
        )
        //console.log('SelectedEnvelope',_state,this.props.data,envelope_index)

        let SelectedEnvelope = SelectedCategory.envelopes[envelope_index];
        let cateogories = this.props.data;

        if(this.props.current_selected_category != null && option == false && this.props.current_selected_category != category_index)
        {
            cateogories[this.props.current_selected_category].envelopes[this.props.current_selected_envelope].is_selected = false;
        }
        cateogories[category_index].envelopes[envelope_index] = _state;
        console.log('testing_____',option,cateogories)
        this.props.onChange({
            current_selected_category : category_index,
            current_selected_envelope : envelope_index,
            cateogories : cateogories,
            cartItem : _state.is_selected ? _state : []
        })
    }
    render(){
        //console.log('_____Render______');

        //console.log(this.props.data)
        let cateogories  = this.props.data;
        var category_list = [];

        var envelope_modal_list = []

        for(var ii = 0 ; ii < cateogories.length ; ii ++){
            var envelope_list = [];
            var envelopes = cateogories[ii].envelopes;
            for(var jj = 0 ; jj < envelopes.length ; jj ++){

                envelope_list.push(
                    <Envelope data={envelopes[jj]} callbackCartHandler={this.handleCart}/>

                )
                envelope_modal_list.push(
                    <EnvelopeModal data={envelopes[jj]} callbackCartHandler={this.handleCart}/>

                )

            }

            category_list.push(
                <div className="collection-inner">
                    <div className="items-contain flex-row js-items-contain">
                    <div className="collection-title-card" data-tag-group="cut" data-tag-name="spotlight" data-tag-count={13}>
                    <div className="collection-info">
                    <h2>
                        spotlight
                    </h2>
                    <h5 className="light-grey">13 pairs</h5>
                    </div>
                </div>
                {envelope_list}
                </div>
                </div>

            )
        }
        return( <div className="builder-panel-inner">
        <div className="panel-header">
          <div className="header-left">
            <div className="sorting">
              <h5 className="inline-block light-grey">Sort</h5>
              <div className="sort-select no-large-up">
                <div className="pretty-select selectric-valid" id="pretty-select-single-sort" data-name>
                  <div className="form-field">
                    <div className="selectric-wrapper selectric-js-select selectric-js-pretty-select selectric-responsive selectric-valid">
                    <div className="selectric-hide-select">

                   </div><div className="selectric"><span className="label">By Cut</span><b className="button"><span className="select-carat" /></b></div><div className="selectric-items" tabIndex={-1}><div className="selectric-scroll"><ul><li data-index={0} className="selected">By Cut</li><li data-index={1} >By Pattern</li><li data-index={2} >By Color</li><li data-index={3} className="last">Best Selling</li></ul></div></div><input className="selectric-input" tabIndex={0} /></div>
                  </div>
                </div>
              </div>
              <div className="sort-toggles">
                <a className="sort-toggle js-sort-toggle active " data-sort="cut" href="javascript:void(0);">By Cut</a>
                <a className="sort-toggle js-sort-toggle " data-sort="pattern" href="javascript:void(0);">By Pattern</a>
                <a className="sort-toggle js-sort-toggle " data-sort="color" href="javascript:void(0);">By Color</a>
                <a className="sort-toggle js-sort-toggle " data-sort="order" href="javascript:void(0);">Best Selling</a>
              </div>
            </div>
          </div>
          <div className="header-right">
            <div className="circle-wrap" style={{display: 'block', opacity: 1}}>
              <div id="scroll-circle" className="circle-init"><canvas width={24} height={24} /></div>
            </div>
          </div>
        </div>
        <div className="builder-collections js-builder-collections">
            {category_list}
        </div>
      </div>)
    }
}

export default EnvelopeList;
