<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script defer src="https://use.fontawesome.com/releases/v5.0.2/js/all.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/css/intlTelInput.css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{-- scripts --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <div id="google_translate_element"></div>
    <script type="text/javascript">
       function googleTranslateElementInit() {
         new google.translate.TranslateElement({pageLanguage: 'es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
       }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    
    <div id = "menu">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item {{ (Route::is('user.register') ? 'active' : '') }}">
                  <!--<a class="nav-link" href="/user_register">Register</a>-->
                  <a class="nav-link" href="/user_register" style="color:#deecfd;">Registrarse</a>
                </li>

                <li>
                  <!--<a class="nav-link" data-toggle="modal" data-target="#myModal" style="cursor:pointer;">Contact Us</a>-->
                  <a class="nav-link" data-toggle="modal" data-target="#myModal" style="cursor:pointer;color:#deecfd;">Formulario de contacto</a>
                </li>

                <li>
                  <!--<a class="nav-link" href="/user_newsregister">News Register</a>-->
                  <a class="nav-link" href="/user_newsregister" style="color:#deecfd;">Recibir noticias</a>
                </li>
                
                
                <li>
                    <a class="nav-link" href="http://viajeswingers.com/web" style="color:#deecfd;">Volver a la Web</a>
                </li>
                
                
                
                
              </ul>
            </div>
        </nav>
    
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
              <strong>{{ $message }}</strong>
      </div>
    @endif
    
    @if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>	
      <strong>{{ $message }}</strong>
    </div>
    @endif

    <div class="containder">
      <div class="row">
          <!--Begin Modal Window--> 
          <div class="modal fade left" id="myModal"> 
            <div class="modal-dialog"> 
              <div class="modal-content"> 
                <div class="modal-header"> 
                  <!--<h3 class="pull-left no-margin">Contact Form</h3>-->
                  <h3 class="pull-left no-margin">Formulario de contacto</h3>
                  <button type="button" class="close" data-dismiss="modal" title="Close"><span class="glyphicon glyphicon-remove"></span>
                  </button> 
                </div> 

                <div class="modal-body">



                  <!--NOTE: you will need to provide your own form processing script--> 
                  <form class="form-horizontal" role="form" method="post" action="/contact"> 
                      {{ csrf_field() }}
                    <div class="form-group row"> 
                      <label for="name" class="col-sm-3 control-label">
                      <!--<span class="required">*</span> Name:</label> -->
                      <span class="required">*</span> Nombre:</label> 
                      <div class="col-sm-9"> 
                        <input type="text" class="form-control" id="name" name="name" placeholder="Escriba nombre..." required> 
                      </div> 
                    </div> 

                    <div class="form-group row"> 
                      <label for="email" class="col-sm-3 control-label">
                      <!--<span class="required">*</span> Email: </label> -->
                      <span class="required">*</span> Mail: </label>
                      <div class="col-sm-9"> 
                        <input type="email" class="form-control" id="email" name="email" placeholder="Escriba Mail..." required> 
                      </div> 
                    </div> 
                  

                    <div class="form-group row"> 
                      <label for="age" class="col-sm-3 control-label">
                        <!--<span class="required">*</span> Age: -->
                        <span class="required">*</span> Año de nacimiento: 
                        
                      </label> 
                      <div class="col-sm-9"> 
                        <!--<input type="number" class="form-control" id="age" name="age" placeholder="Your Age" required>-->
                        <input type="number" class="form-control" id="age" name="age" placeholder="Año de nacimiento" required> 
                      </div> 
                    </div> 


                    <div class="form-group row"> 
                      <label for="city" class="col-sm-3 control-label">
                      <!--<span class="required">*</span> City: </label> -->
                      <span class="required">*</span> Ciudad: </label> 
                      <div class="col-sm-9"> 
                        <input type="city" class="form-control" id="city" name="city" placeholder="ciudad" required> 
                      </div> 
                    </div> 


                    <div class="form-group row"> 
                      <label for="country" class="col-sm-3 control-label">
                      <!--<span class="required">*</span> Country: </label> -->
                      <span class="required">*</span> Pais: </label> 
                      

                      <div class="col-sm-9"> 
                        <!--<input type="country" class="form-control" id="country" name="country" placeholder="Your Country" required> -->
                        <input type="country" class="form-control" id="country" name="country" placeholder="Pais" required> 
                      </div> 
                    </div> 

                    <div class="form-group row"> 
                      <label for="message" class="col-sm-3 control-label">
                        <!--<span class="required">*</span> Message:</label> -->
                        <span class="required">*</span> Mensaje:</label> 
                        <div class="col-sm-9"> 
                          <textarea name="message" rows="4" required class="form-control" id="message" placeholder="Mensaje"></textarea> 
                        </div> 
                    </div> 
                  
                    <div class="form-group custom-checkbox" style="cursor:pointer;"> 
                      <input type="checkbox" id="terms" class="col-control-input" name="terms" required="">
                      <a href="http://viajeswingers.com/terminosycondidiones.php" target="_blank">
                          <!--<label class="col-form-label" style="color:#2793db;cursor:pointer;"><font style="vertical-align: inherit;">I accept privacy policy and system conditions.</font></label>-->
                          <label class="col-form-label" style="color:#2793db;cursor:pointer;"><font style="vertical-align: inherit;">Acepto politica de privacidad y condiciones de la pagina.</font></label>
                          
                      </a>
                    </div>
                  
                    <div class="form-group row" style="float: right;"> 
                      <div class="col-sm-offset-3 col-sm-6"> 
                        <!--<button type="submit" id="contact_submit" name="submit" class="btn-lg btn-primary">SUBMIT</button>-->
                        <button type="submit" id="contact_submit" name="submit" class="btn-lg btn-primary">Enviar</button> 
                      </div> 
                    </div> 
                  </form>

                </div>

                <div class="modal-footer"> 
                  <!--<button class="btn-sm close" type="button" data-dismiss="modal">Close</button>-->
                  <button class="btn-sm close" type="button" data-dismiss="modal">Cerrar</button> 
                </div> 
              </div> 
            </div> 
          </div>
      </div> 
    </div>
    <main class="py-4">
        @yield('content')
    </main>
    
</body>
</html>
