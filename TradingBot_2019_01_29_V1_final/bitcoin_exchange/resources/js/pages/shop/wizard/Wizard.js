import React from 'react'
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import EnvelopeList from '../../../components/envelope/list/EnvelopeList'
import Letter from '../../../components/letter/Letter'
import Letterwriter from '../../../components/writeletter/Letterwriter'
import 'react-tabs/style/react-tabs.css';
import './wizard.css'
import Scroll from 'react-scroll';

var Link = Scroll.Link;
var DirectLink = Scroll.DirectLink;
var Element = Scroll.Element;
var Events = Scroll.Events;
var scroll = Scroll.animateScroll;
var scrollSpy = Scroll.scrollSpy;
class Wizard extends React.Component{
    constructor(props) {
        super(props);
        //console.log(this.props)
        this.state = {
            cartItem : [],
            tabIndex: 0 ,
            is_selected_envelope : false,
            is_writable_letter : false,
            is_selected_letter : 0,
            current_selected_envelope : null,
            current_selected_category : null,
            envelope_categories :  [   ],
            total_letter_count : 0,
            letter_categories : [
                {
                    category_id : 1,
                    category_name : 'New 1',
                    letters : [
                        {
                            category_id : 1,
                            category_name : 'New 1',
                            letter_id : 1,
                            letter_title : 'New Letter',
                            letter_template : 'http://ktunesound.com/wp-content/uploads/parent-flyer-templates-parent-flyer-templates-yourweek-ef52b7eca25e.png',
                            letter_image : "https://lh6.googleusercontent.com/0ztw8fMmHbSjWTpM6MHIZrFcpJIrCA7C8QDKSUqaSD3Yi0Wz_6_dbq7GaTwur31jMp0bfqVts5-3vojs_Ns7=w1920-h889-rw",
                            letter_size : 'A4',
                            letter_line : 16,
                            letter_text_count : 250,
                            letter_caracter_count : 2,
                            letter_price : 14,
                            count : 0
                        }
                    ]
                },
                {
                    category_id : 2,
                    category_name : 'New 2',
                    letters : [
                        {
                            category_id : 2,
                            category_name : 'New 2',
                            letter_id : 2,
                            letter_title : 'New Letter 2',
                            letter_template : 'http://ktunesound.com/wp-content/uploads/parent-flyer-templates-parent-teacher-conference-flyer-template-transition-fair-and.png',
                            letter_image : "https://lh6.googleusercontent.com/4cc7kJJVq8KOKLs4glztxYvu1hGg7kVOvUMhrOTeHqHlxCi5I0uieQP1YCRnlswuc1tPgj9VZDWEyCP6a9P6=w1920-h889-rw",
                            letter_size : 'A4',
                            letter_line : 16,
                            letter_text_count : 250,
                            letter_caracter_count : 2,
                            letter_price : 14,
                            count : 0
                        },
                        {
                            category_id : 2,
                            category_name : 'New 2',
                            letter_id : 3,
                            letter_title : 'New Letter 3',
                            letter_template : 'http://ktunesound.com/wp-content/uploads/parent-flyer-templates-parent-teacher-conference-flyer-template-transition-fair-and.png',
                            letter_image : "https://lh6.googleusercontent.com/0ztw8fMmHbSjWTpM6MHIZrFcpJIrCA7C8QDKSUqaSD3Yi0Wz_6_dbq7GaTwur31jMp0bfqVts5-3vojs_Ns7=w1920-h889-rw",
                            letter_size : 'A4',
                            letter_line : 16,
                            letter_text_count : 250,
                            letter_caracter_count : 2,
                            letter_price : 14,
                            count : 0
                        }
                    ]
                }
            ]
        };
        this.handleChooseEnvelope = this.handleChooseEnvelope.bind(this)
        this.handleChangeCategories = this.handleChangeCategories.bind(this)
        this.handleLetterCart = this.handleLetterCart.bind(this)
      }
      componentDidMount(){
        fetch('/api/getEnvelopeByCategories')
            .then(response => response.json())
            .then(data => {
                //console.log('fetched_data', data.result)
                this.setState({ envelope_categories : data.result });

            });

    }
      handleChooseEnvelope(data){
          this.setState(
              {
                current_selected_envelope : data.current_selected_envelope,
                current_selected_category : data.current_selected_category,
                envelope_categories : data.cateogories,
                is_selected_envelope : data.cateogories[data.current_selected_category].envelopes[data.current_selected_envelope].is_selected ? true : false,
                cartItem : data.cartItem
              }
          )
          //console.log('Point_1', data.cartItem)
          this.props.handleCart(data.cartItem)
        this.handleLetterCart();
      }
      handleChangeCategories(_category_id, option, _state){
        if(option == 1) {
            if(this.state.total_letter_count <4){

            this.setState({
                is_writable_letter : true,
                total_letter_count : this.state.total_letter_count +1,
                letter_categories : _state
            })
            }
        }
        else{
            if(this.state.total_letter_count > 0){
                if(this.state.total_letter_count == 1){
                    this.setState({
                        is_writable_letter : false,
                        total_letter_count : this.state.total_letter_count - 1,
                        letter_categories : _state
                    })
                }
                else{
                    this.setState({
                    is_writable_letter : true,
                    total_letter_count : this.state.total_letter_count - 1,
                    letter_categories : _state
                })
                }

            }
        }
        this.handleLetterCart();
    }
    handleLetterCart(){
        let cartItems = [];
        let {letter_categories} = this.state;
        letter_categories.forEach((category) =>{
            // console.log(category)
            category.letters.forEach((letter) =>{
                if(letter.count > 0){
                    cartItems.push(letter)
                }
            })
        })
        console.log("cartLetterItem", cartItems)
        this.props.handleCartLetter(cartItems)
    }
    render(){
        //console.log('_Render_wizard', this.state.envelope_categories)
        return(
            <Tabs selectedIndex={this.state.tabIndex} onSelect={tabIndex => this.setState({ tabIndex })}>
                <TabList className='row'>
                    <Tab className='col-md-3 tab_menu'>Envelope</Tab>
                    <Tab  className='col-md-3 tab_menu' disabled={!this.state.is_selected_envelope}>Letter</Tab>
                    <Tab  className='col-md-3 tab_menu' disabled={!this.state.is_writable_letter}>Write Letter</Tab>
                    <Tab  className='col-md-3 tab_menu'>Title 4</Tab>
                </TabList>
                <TabPanel>
                        <Element name="test7" className="element" id="containerElement" style={{
                            position: 'relative',
                            height:" calc(100vh - 240px)",
                            overflow: 'scroll',
                            marginBottom: '100px'
                            }}>
                <div id="builder-panel" className="has-absolute" data-active-sort="cut">
                                <EnvelopeList data = {this.state.envelope_categories} current_selected_envelope = {this.state.current_selected_envelope} current_selected_category={this.state.current_selected_category} onChange={this.handleChooseEnvelope}/>
                                </div>
            </Element>

                </TabPanel>
                <TabPanel>
                <Element name="test7" className="element" id="containerElement" style={{
                            position: 'relative',
                            height:" calc(100vh - 240px)",
                            overflow: 'scroll',
                            marginBottom: '100px'
                            }}>
                <div id="builder-panel" className="has-absolute" data-active-sort="cut">
                                <Letter categories ={this.state.letter_categories} handleChangeStateCategories = {this.handleChangeCategories}  />
                                </div>
                </Element>
                </TabPanel>
                <TabPanel><Element name="test7" className="element" id="containerElement" style={{
                            position: 'relative',
                            height:" calc(100vh - 240px)",
                            overflow: 'scroll',
                            marginBottom: '100px'
                            }}>
                            <Letterwriter letters={this.props.cartedLetter}/> </Element></TabPanel>
                <TabPanel>d</TabPanel>
            </Tabs>
        )
    }
}
export default Wizard;
