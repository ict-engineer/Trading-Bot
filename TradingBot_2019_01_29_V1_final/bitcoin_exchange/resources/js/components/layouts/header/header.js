import React from 'react';
import Logoimage from '../../../images/logo.jpg'
import { Link } from 'react-router-dom'
import './header.css'
class Header extends React.Component{
    constructor(props){
        super(props)
        this.state = {
            menu : []
        }
    }

    render () {
        return(
            <div className=" ">
            <div className="row">
              <div className="col-md-4">
                <div className="logo">
                <Link to='/'><img src={Logoimage} alt="logo" className='logo-img' /></Link>
                </div> {/* .logo */}
              </div>
              <div className="col-md-8">
                <Link to="#" className="user-links-toggler"><i className="fa fa-bars" /></Link>
                <div className="user-links clearfix">
                  <div className="social-links">
                    <Link to="#" className="facebook"><i className="fa fa-facebook" /></Link>
                    <Link to="#" className="twitter"><i className="fa fa-twitter" /></Link>
                    <Link to="#" className="google-plus"><i className="fa fa-google-plus" /></Link>
                    <Link to="#" className="pinterest"><i className="fa fa-pinterest" /></Link>
                  </div> {/* .social */}
                  <div className="account-links">
                    <a href="/login"><i className="fa fa-lock" /> Login</a>
                  </div> {/* .account-links */}
                  <div className="secondary-menu">
                    <Link to="/">Home</Link>
                    <Link to="/shop">Shop</Link>
                    <Link to="#">Blog</Link>
                    <Link to="#">Contact Us</Link>
                  </div> {/* .secondary-menu */}
                </div> {/* .user-links */}
                <div className="mobile user-links clearfix">
                  <div className="secondary-menu">
                    <Link to="#">Home</Link>
                    <Link to="#">About Us</Link>
                    <Link to="#">Blog</Link>
                    <Link to="#">Contact Us</Link>
                  </div> {/* .secondary-menu */}
                  <div className="account-links">
                    <Link to="#"><i className="fa fa-lock" /> Login</Link>
                  </div> {/* .account-links */}
                  <div className="social-links">
                    <Link to="#" className="facebook"><i className="fa fa-facebook" /></Link>
                    <Link to="#" className="twitter"><i className="fa fa-twitter" /></Link>
                    <Link to="#" className="google-plus"><i className="fa fa-google-plus" /></Link>
                    <Link to="#" className="pinterest"><i className="fa fa-pinterest" /></Link>
                  </div> {/* .social */}
                </div> {/* .mobile.user-links */}
              </div>
            </div>
            </div>
        )
    }
}


export default Header;
        