<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>The Lighting & Sound Co. | Services</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">
    
        <!-- Custom CSS -->
    <link href="css/bootstrap-datepicker.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <!------ Google Analytics ----->
<!---<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-19822327-8', 'auto');
  ga('send', 'pageview');

</script> -->

    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="http://www.lightingandsoundco.com/index"><img src="images/logo.png" width="50" height="50"  alt="Lighting and Sound Logo"/></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="http://www.lightingandsoundco.com/contact">Contact</a>
                    </li>
                    <li>
                        <a href="http://www.lightingandsoundco.com/services">Services</a>
                    </li>
                    <li class="dropdown">
                        <a href="http://www.lightingandsoundco.com/#" class="dropdown-toggle" data-toggle="dropdown">Portfolio <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="http://www.lightingandsoundco.com/weddings">Weddings</a>
                            </li>
                            <li>
                                <a href="http://www.lightingandsoundco.com/events">Special Events</a>
                            </li>
                            <li>
                                <a href="http://www.lightingandsoundco.com/concerts">Concerts</a>
                            </li>
                            <li>
                                <a href="http://www.lightingandsoundco.com/showdesign">Show Design</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="http://www.lightingandsoundco.com/about">About</a>
                    </li>
                    <li>
                        <a href="http://www.lightingandsoundco.com/blog">Blog</a>
                    </li>
                    <li>
                      <a href="http://www.lightingandsoundco.com/quote"><button type="button" style="border-radius:5px; margin-top:-4px;" class="btn-danger">Get a Quote</button></a>
                  </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Get a Quote
                    <small>How can we help?</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="http://www.lightingandsoundco.com/index">Home</a>
                    </li>
                    <li class="active">Get a Quote</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-md-8">
                <h3>Send us a Message</h3>
                <form method="post" name="sentMessage" action="contact_me.php" id="contactForm" novalidate>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Full Name:</label>
                            <input type="text" name="name" class="form-control" id="name" required data-validation-required-message="Please enter your name.">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address:</label>
<!--                            <input type="email" class="form-control" id="email" required data-validation-required-message="Please enter your email 											 							address."> -->
                            <input type="text" name="email" class="form-control" id="email" required data-validation-required-message="Please enter your email 											 							address.">
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
  						<label>Type of Event:</label>
  							<select name="type" class="form-control" id="type">
   								 <option value="1">--Select Event Type--</option>
   								 <option value="2">2</option>
      							 <option value="3">3</option>
      							 <option value="4">4</option>
    						</select>
   						</div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>If other, describe:</label>
                            <input type="text" name="other" class="form-control" id="other" required data-validation-required-message="Please enter your name.">
                            <p class="help-block"></p>
                        </div>
                    </div>
                    
                    <div class="form-group row">
  						<div class="col-xs-8">
    						<label>Event Date:</label>
    							<div class="input-group date">
  							<input type="text" name="date" class="form-control" id="date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
								</div>
   						 </div>
  					</div>
                    
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Venue:</label>
                            <input type="text" name="venue" class="form-control" id="venue" required data-validation-required-message="Please enter your name.">
                            <p class="help-block"></p>
                        </div>
                    </div>
					<div class="control-group form-group">
                        <div class="controls">
  						<label>Budget:</label>
  							<select name="budget" class="form-control" id="budget">
   								 <option value="1">--Select Budget Range--</option>
   								 <option value="2">2</option>
      							 <option value="3">3</option>
      							 <option value="4">4</option>
    						</select>
   						</div>
                    </div>          
                    <div class="control-group form-group">
                        <div class="controls">
                        <label>Services Required:</label> <br />
							<ul class="checkbox-grid">
                                <li><input type="checkbox" name="services[]" value="value1" /> Text 11</li>
    							<li><input type="checkbox" name="services[]" value="value2" /> Text 12</li>
                                <li><input type="checkbox" name="services[]" value="value3" /> Text 11</li>
    							<li><input type="checkbox" name="services[]" value="value4" /> Text 12</li>
                                <li><input type="checkbox" name="services[]" value="value5" /> Text 11</li>
    							<li><input type="checkbox" name="services[]" value="value6" /> Text 12</li>
                                <li><input type="checkbox" name="services[]" value="value7" /> Text 11</li>
    							<li><input type="checkbox" name="services[]" value="value8" /> Text 12</li>
                                <li><input type="checkbox" name="services[]" value="value9" /> Text 11</li>
    							<li><input type="checkbox" name="services[]" value="value10" /> Text 12</li>
                                <li><input type="checkbox" name="services[]" value="value11" /> Text 11</li>
    							<li><input type="checkbox" name="services[]" value="value12" /> Text 12</li>
                            </ul> 
                         </div>
                     </div><br><br><br> 
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Message:</label>
                            <textarea name="message" rows="10" cols="100" class="form-control" id="message" required data-validation-required-message="Please enter your 							message" maxlength="999" style="resize:none"></textarea>
                        </div>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6Ld1OQkTAAAAAFxEskl32wWo3zfcfXDyJHAzOKTm"></div><br>
                    <div id="success"></div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form><!-- For success/fail messages -->
                            </div>

        </div>
        <hr>

        <!-- Footer -->
        <footer>
          <img src="images/logo.png" width="100" height="100"  alt="lightingandsoundcologo"/>
          <p>Copyright &copy; The Lighting & Sound Co. 2015 </p>      
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>
    
    <script src="js/bootstrap-datepicker.js"></script>
    

</body>

</html>

