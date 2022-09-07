import React from "react";
import './profile.css'
class Profile extends React.Component{
    render(){
        return(
<form>
        <div className="container">
          <div className="row">
            <div className="col-md-9">
              <div className="panel panel-default">
                <div className="panel-body">
                  <div className="row">
                    <div className="col-md-12 lead">
                      Edit user profile
                      <hr />
                    </div>
                  </div>
                  <div className="row">
                    <div className="col-md-4 text-center">
                      <div id="img-preview-block" className="mx-auto img-circle avatar avatar-original center-block" style={{backgroundSize: 'cover', backgroundImage: 'url(http://robohash.org/sitsequiquia.png?size=120x120)'}} />
                      <br />
                      <span className="btn btn-link btn-file">Edit avatar <input type="file" id="upload-img" /></span>
                    </div>
                    <div className="col-md-8">
                      <div className="form-group">
                        <label htmlFor="user_last_name">Name</label>
                        <input type="text" className="form-control" id="user_last_name" />
                      </div>
                      <div className="form-group">
                        <label htmlFor="user_first_name">Phone Number</label>
                        <input type="text" className="form-control" id="user_first_name" />
                      </div>
                      <div className="form-group">
                        <label htmlFor="user_middle_name">Country</label>
                        <input type="text" className="form-control" id="user_middle_name" />
                      </div>
                      <div className="form-group">
                        <label htmlFor="user_middle_name">City</label>
                        <input type="text" className="form-control" id="user_middle_name" />
                      </div>
                      <div className="form-group">
                        <label htmlFor="user_middle_name">Favorite Member</label>
                        <textarea type="text" className="form-control" id="user_middle_name" ></textarea>
                      </div>

                    </div>
                  </div>
                  <div className="row">
                    <div className="col-md-12">
                      <hr />
                      <button className="btn btn-primary pull-right"><i className='fa fa-save'></i> Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </form>
        )
    }
}

export default Profile;
