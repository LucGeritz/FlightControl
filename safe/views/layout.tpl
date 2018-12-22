<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>FlightControl</title>
		<link rel="stylesheet" href="{{$base}}/assets/fc.css">
	</head>
	
	<body>
		<header>
			<div class="main-image">
				<img src="assets/fclogo.jpg">
			</div>
			<div class="nav">
			<ul>
    			<li><a href="{{$base}}/" [[if($action=='home'):]]class="active"[[endif]]>Home</a></li>
    			<li><a href="{{$base}}/examples"  [[if($action=='examples'):]]class="active"[[endif]]>Examples</a></li>
    			<li><a href="{{$base}}/get-started"  [[if($action=='get-started'):]]class="active"[[endif]]>Get&nbsp;started</a></li>
				<li><a href="{{$base}}/about" [[if($action=='about'):]]class="active"[[endif]]>About</a></li>
    		</ul>
    	</div>
  		</header>
	
		<div class='content'>
		[: block content :][: endblock :]
		</div>
		<script src="{{$base}}/assets/microlight.js"></script>
	</body>
</html>


