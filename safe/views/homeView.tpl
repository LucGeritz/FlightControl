[[ $this->inherit($mainView); ]]
[: block content :]
<h2>What is FlightControl?</h2>
<p><strong>FlightControl</strong> is an <em>addition</em> to the <a href="">Flight framework</a>. Flight itself is a fast, simple framework for PHP which enables you to quickly and easily build RESTful web applications.</p>
<p>Flight does offer basic view support but <strong>FlightControl</strong> adds real <em>controllers</em> and <em>view templates</em> which allow you to build real webpage applications where logic and presentation are separated.</p>
<h2>Controllers</h2>
<p>To handle a route FlightControl has extended Flight with the <code>fly()</code> method.</p>
<code class="microlight">Flight::route('/getstarted', function(){
    Flight::fly(new GetStartedCtrl());
});
</code>
<p>In this example the route <code>getstarted</code> is requested. This route is handled by passing an instance of the controller <code>GetStartedCtrl</code> to the <code>fly()</code> method.</p>

<p>A controller like <code>GetStertedCtrl</code> extends the <code>BaseCtrl</code> class.</p>
<code class="microlight">class GetStartedCtrl extends BaseCtrl{

	public function getView(){
		return 'getstartedView';
	}

	public function start(){
		$this->data['title'] = 'How to get started';
	}

}</code>
<p>The most important, and only mandatory method of the controller is <code>start()</code>. This is where the controller 'does things'. One of its responsibilities is to populate its <code>$this->data</code> array. Elements of this array are accessible as variables in the view. E.g. <code>$this->data['title']</code> becomes <code>&#123;&#123;$title&#125;&#125;</code> in the view. In real life the data will be calculated, derived, read from a database etc. and probably won't be hardcoded as in this example.</p>
<p><code>getView()</code> returns the name of the associated view. This approach allows one controller to handle different views, e.g. depending on the input. Several variations are possible, you can pass a view by passing it as 2nd parameter of the <code>fly()</code> method, or use no view at all, see <a href="{{$base}}/examples">the examples</a>.</p>
<h2>Views</h2>
<p>
For templating FlightControl uses an (only slightly) adapted version of <em>Templum</em>. It wouldn't make sense to use a huge template system like <em>smarty</em> in Flight. <em>Templum</em> is fast and very compact (140 lines of code). Still it offers some great functionality. The one I like best is <em>inheritance</em> which FlightControl uses to display content within a parent template typically containing a header, navbar and footer.</p>
<p>Your main template file might look like this:</p>
<code class="microlight">&lt;!DOCTYPE html>
&lt;html>
    &lt;body>
        &lt;header>
            &lt;h1>FlightControl&lt;/h1>
        &lt;/header>

        &lt;div class='content'>
        &#91;: block content :&#93;
        &#91;: endblock :&#93;
        &lt;/div>

        &lt;footer>
            Mail me at somedude@phpis.ok
        &lt;/footer>
    &lt;/body>
&lt;/html>
</code>
<p>Take note of the <code>&#91;: block content :&#93;</code> to <code>&#91;: endblock :&#93;</code></p>
<p>Next an example of a child template</p>
<code class="microlight">&#91;&#91; $this->inherit($mainView); &#93;&#93;
&#91;: block content :&#93;
&lt;h2>Example&lt;/h2>
&lt;p>Some nice text&lt;/p>
&#91;: endblock :&#93;
</code>
<p>The child template first states that it's a child of the main view. (<code>&#91;&#91;</code> ... <code>&#93;&#93;</code> denotes a temporary switch to php.) In effect the child view now has all the content of the main view. It overrides the part in block <code>content</code> however. A very elegant mechanism!</p>
<p>Templum is made by Ferry Boender. For more info on Templums take a look at <a href="https://github.com/fboender/templum">Templum on GitHub</a></p>.
<h2>Modules</h2>
A useful addition are FlightControl <em>modules</em>. These allow you to add reusable functionality to FlightControl while keeping its core compact. Inside a module you can define dependencies to other modules which the module loader will load as well. The way modules work is explained quite well in the source of <code>classes/ModLoader</code>.
[: endblock :]

