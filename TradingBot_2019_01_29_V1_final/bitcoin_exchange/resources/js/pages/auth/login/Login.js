import React from 'react'
import './login.css'
class Login extends React.Component{
    constructor(props)
    {
        super(props)

    }
    render(){
        return(
            <div id="login-row" className="row justify-content-center align-items-center">
            <div id="login-column" className="col-md-6">
              <div className="box">
                <div className="shape1" />
                <div className="shape2" />
                <div className="shape3" />
                <div className="shape4" />
                <div className="shape5" />
                <div className="shape6" />
                <div className="shape7" />
                <div className="float">
                  <form className="form" action>
                    <div className="form-group">
                      <label htmlFor="username" className="text-white">Username:</label><br />
                      <input type="text" name="username" id="username" className="form-control" />
                    </div>
                    <div className="form-group">
                      <label htmlFor="password" className="text-white">Password:</label><br />
                      <input type="text" name="password" id="password" className="form-control" />
                    </div>
                    <div className="form-group">
                      <input type="submit" name="submit" className="btn btn-info btn-md" defaultValue="submit" />
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        )
    }
}
export default Login
