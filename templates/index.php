<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Blinkey I/O</title>
    <link href="/static/css/bootstrap.css" rel="stylesheet">
    <link href="/static/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="/static/css/docs.css" rel="stylesheet">
    <!-- This next file, don't know where it is, sorry -->
    <link href="/static/js/google-code-prettify/prettify.css" rel="stylesheet">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="/static/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="/static/js/bootstrap.js"></script>

</head>
<body>
<div class="container" style="height: 70px;">
	<div class="page-header">		
		<h1>Blinkey I/O</h1>
	</div>
	<div class="row-fluid well">
		<h4>Pattern to create:</h4>
		<div class="padding10 well span5" style="background:grey;">
		<img src="/static/images/led_on.png"/>	
		<img src="/static/images/led_off.png"/>	
		<img src="/static/images/led_on.png"/>	
		<img src="/static/images/led_on.png"/>	
		<img src="/static/images/led_off.png"/>	
		<img src="/static/images/led_off.png"/>	
		<img src="/static/images/led_on.png"/>	
		<img src="/static/images/led_off.png"/>	
		<!--
		<a href="#" class="btn btn-info" style="float:right;" >Set</a>
		-->
		</div>
	</div>
	<div class="row-fluid well">
		<div class="span4 well" style="background:white;">
		<h5>Drag the blocks to the queve:</h5>
		
		<div class="ui-widget-content">
			<img src="/static/images/and.jpg"/>
		</div>

		</div>
		<div class="span6 row well" style="background:white;height:400px;">
		    <div class="btn-group">
			    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				Select <br/>operator<br/>
				<span class="caret"></span>
			    </a>
		    <ul class="dropdown-menu">
	            <li><img src="/static/images/and.jpg"/></li>
		    <li><img src="/static/images/or.jpg"/></li>
  		    <li><img src="/static/images/xor.jpg"/></li>
		    </ul>
		    </div>

		</div>
	</div>
</div>
</body>
</html>


