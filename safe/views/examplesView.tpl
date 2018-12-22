[[ $this->inherit($mainView); ]]
[: block content :]
<div class="content">
	<h2>Some Examples</h2>
	<p>Some examples of controller - view combinations</p>
	<div class="notes">
	<ol>
		<li><a href="{{$base}}/simple">A simple controller - simple view</a></li>
		<li><a href="{{$base}}/variable">A fickle controller - variable views</a></li>
		<li><a href="{{$base}}/secret">A secret controller - for authenticated users only</a></li>
		<li><a href="{{$base}}/noview">Out of Control? - A view without a controller</a></li>
		<li><a href="{{$base}}/logout">Logout - a controller without a view</a></li>
	</ol>
	<em>Logout</em> is explained on the <em>A secret controller</em>-view.
	</div>
</div>

[: endblock :]

