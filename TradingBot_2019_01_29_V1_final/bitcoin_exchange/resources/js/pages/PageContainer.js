import React from 'react'
import { Switch, Route } from 'react-router-dom'
import Home from '../pages/home/Home'
import Shop from '../pages/shop/Shop'
import Login from '../pages/auth/login/Login'
import Profile from '../pages/profile/Profile'
class PageContainer extends React.Component{
    constructor(props){
        super(props)

    }
    render(){
        return(
            <main className="wrapper">
                <Switch>
                    <Route exact path='/' component={Home}/>
                    <Route  path='/home' component={Home}/>
                    <Route  path='/shop' component={Shop}/>
                    <Route  path='/profile' component={Profile}/>
                    <Route  path='/login' component={Login}/>
                </Switch>
            </main>)
    }
}
export default PageContainer;
