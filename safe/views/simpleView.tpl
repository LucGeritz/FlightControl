[[ $this->inherit($mainView); ]]
[: block content :]
<h2>A simple controller with a view</h2>
<p>Today's date is {{$date}}</p>
<p>You are using FlightControl version {{$version}}</p>
<div class="notes">
<p>The <code>SimpleCtrl</code> gathers the data for the <code>simpleView</code></p>
<code class="microlight">class SimpleCtrl extends BaseCtrl{
	
	public function start(){
		$this->data['version'] = Flight::get('fc_version');
		$this->data['date'] = date('Y-m-d');
	}
	
}</code>
<p>The view used is decided by the caller of <code>fly()</code>. Note the second parameter <code>'simpleView'</code> which determines the view used.</p>
<code class="microlight">Flight::route('/simple', function(){
	Flight::fly(new SimpleCtrl(),'simpleView');
});</code>
<p>The view looks like this:</p>
<code class="text-block">&#91;&#91; $this->inherit(&#123;&#123;$mainView&#125;&#125;); &#93;&#93;
&#91;: block content :&#93;
&lt;div class="content">
&lt;h2>A simple controller with a view&lt;/h2>
&lt;p>Today's date is &#123;&#123;$date&#125;&#125;&lt;/p>
&lt;p>You are using FlightControl version &#123;&#123;$version&#125;&#125;&lt;/p>
&lt;/div>
&#91;: endblock :&#93;</code>
<p>Things of interest are:</p>
<p>The view inherits from the main view, see line <code>&#91;&#91; $this->inherit(&#123;&#123;$mainView&#125;&#125;); &#93;&#93;</code>. The name of the mainView is stored in <code>$mainView</code>.</p>
</div>
[: endblock :] 