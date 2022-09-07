import React, {Component} from 'react';
import { Router, Route, Link } from 'react-router';
import Header from './layouts/header/header'
import PageContainer from '../pages/PageContainer'
import {Icon} from 'react-fa'
import './master.css'
import './responsive.css'
class Master extends Component {
    constructor(props){
        super(props)
        this.state = {
            isLoggedIn: false,
            user: {}
        };
    }
    componentDidMount() {

      }
    render(){
        return (
        <div className='builder-empty' id="builder">
            <Header/>
            <PageContainer/>
        </div>
        )
    }
}
export default Master;
