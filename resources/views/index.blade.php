<!DOCTYPE html>
@if(!Session::has('user_unique_id'))
    <script type="text/javascript">window.location.href = './login'; ;</script>
@endif
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">{{ Session::get('username') }}</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>
  
<div class="container">
  <h3>The Basic Example of user registration</h3>
  <p>Username : {{ Session::get('username') }}</p>
  <p>Email : {{ Session::get('email') }}</p>
  <p>This is session data</p>
</div>

<form method="post" action="{{ route('changePass') }}">
    @csrf
    <label>Enter New Password</label>
    <input type="password" name="password"><br>
    <label>Re-enter Password</label>
    <input type="password" name="password_confirmation">
    <input type="submit" name="Change Password">
</form>

</body>
</html>
