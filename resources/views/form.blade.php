<html>
<head>
	<title>Login User</title>
</head>
<body>

	@if(Session::has('email'))
	  <h1>{{ session('email') }}</h1>
	  @endif
	
</body>
</html>