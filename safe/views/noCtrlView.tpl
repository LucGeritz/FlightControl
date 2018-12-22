[[ $this->inherit($mainView); ]]
[: block content :]
<h2>Out of Control?</h2>
<p>A view without a controller!</p>
<div class="notes">
<p>If a view is static, i.e. contains no dynamic data then you could decide not to use a controller. You can use the <code>Flight::render()</code> method. This method is remapped by FlightControl, it will still show your view as part of the main view if you inherit it correctly.</p>
<p>The route definition:</p>
<code class="microlight">Flight::route('/noview', function(){
	Flight::render('noCtrlView');
});
</code>
<p>Obviously, if this page needs authentication it will still need a controller, even if it's a static page..</p>
</div>
[: endblock :]

