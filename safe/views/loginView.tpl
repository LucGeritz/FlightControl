[[ $this->inherit($mainView); ]]
[: block content :]

<h2>Please log in</h2>
<p>This demonstrates a controller which needs you to be logged in. It seems you're not so a login view is displayed.</p>
<p>How about user <code>demo</code> with password <code>demo</code></p>

<form method="post" action="{{$base}}{{$url}}">

	<label>Username</label>
	<input type="text" value="{{$username}}" name="username" required />

	<label>Password</label>
	<input type="password" value="{{$password}}" name="password"  required />
	<br>
	<button type="submit" name="submit-login">Ok</button>
		
	@if(isset($error)):
	<div class="error-msg">{{$error}}</div>
	@endif;
</form>
[: endblock :] 