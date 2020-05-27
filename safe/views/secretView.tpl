[[ $this->inherit($mainView); ]]
[: block content :]
<h2>A secret view</h2>
<p>Very secret information here. But apparently you are logged in so it's ok to present this view..</p>
<p>To logout out choose the <a href="{{$base}}/logout">logout controller</a>.</p>
<div class="notes">
<h3>Just a suggestion</h3>
<p>
It is important to note that FlightControl <strong>does not</strong> supply you with a security component. FlightControl <em>does</em> have suggestions on <em>where</em> within the framework you could implement authorization while keeping your flow simple without unnecessary redirections.</p>
<p>If you look at the source of <code>BaseCtrl</code>, you'll note a <code>isAuth()</code> method which always returns <code>true</code>, meaning <q>Ok, you're authorized, continue.</q></p>
<p>The suggested way of implementing checking authorization is by adding another 'layer' (<em>class</em> really) between <code>BaseCtrl</code> and your class. Your class then needs to extend from this class instead of <code>BaseCtrl</code>. In this package an example is provided with <code>AuthCtrl</code></p>.
<code class="microlight">abstract class AuthCtrl extends BaseCtrl{

    private function checkAuth($user, $password){
        return $user=='demo' && $password=='demo';
    }

     public function isAuth(){

        $loggedIn = false;

        if(isset($_POST['submit-login'])){
           // credentials were submitted
           $_SESSION['username'] = $_POST['username'];
           $_SESSION['password'] = $_POST['password'];
        }

        if(isset($_SESSION['username']) && isset($_SESSION['password'])){
           $loggedIn = $this->checkAuth($_SESSION['username'], $_SESSION['password']);
        }

        $_SESSION['loggedin']=$loggedIn;

        if(!$loggedIn && isset($_POST['submit-login'])){
            Flight::view()->setVar('error','Invalid username or password');
        }

        Flight::view()->setVar('loggedIn',$loggedIn);
        return $loggedIn;

     }
}</code>
<h3>Overriding isAuth</h3>
<p>This class overrides the <code>isAuth()</code> method. It's up to this class' method now to decide if the user is authorized. Here it tries to retrieve username and password from either post or session. It then checks the credentials with some hardcoded values. Of course on a real site here's where you do your complicated stuff. Get access to a database, do some decrypting, hashing, those kind of things.</p>
<h3>The unauthCallback</h3>
<p>We're not done yet. In <code>isAuth</code> some <code>$_POST</code> values are used to determine the logged-in status. These come from a form which was offered to the user on which it supplied credentials. Where does this form come in?</p>
<p>By now you know a FlightControl route is kicked off with <code>Flight::fly()</code>. The <code>fly()</code> method is a method of the <code>Pilot</code> and if you're not interested in implementing authorization in the FlightControl-suggested way you'd never need to know about its existance. But since you know of it by now, we might as well continue.</p>
<p>The first thing <code>Pilot</code> does (in <code>fly()</code>) is call <code>isAuth()</code>. If this returns false it calls a <em>callback</em> (the <em>unAuthCallback</em>). This callback should return a controller instance which is used instead of the one originally supplied. Typically (but not necessarily) this alternate controller will provide the login form. Once submitted this form will lead you to the original requested controller but now with hopefully the right credentials in the <code>$_POST</code> array. The credentials are stored in the $_SESSION array to prevent the user from having to log in again for every restricted page.</p>
<p>The developer is the one who supplies the <em>unAuthCallback</em>. This is done the moment <code>fly()</code> is mapped to Flight and the <code>Pilot</code> is created.</p>
<code class="microlight">Flight::map('fly',[new Pilot(function($url){
	// constructor parameter is the controller-object used in case user is unauthorized
	return new LoginCtrl($url);
}),'fly']);
</code>
<p>The callback is passed as parameter to the constructor of <code>Pilot</code> and as stated should return a controller instance. Here <code>LoginCtrl</code> is returned. Also note that <code>Pilot</code> always passes the original URL to this callback. This comes in handy as value for the <code>action</code> attribute of the login form.</p>
<p>Next let us look at the <code>LoginCtrl</code> example.</p>
<code class="microlight">class LoginCtrl extends BaseCtrl{

    private $url; // the requested url before we 'redirected' to the login

    public function getView(){
        return 'loginView';
    }

	public function start(){

        $this->data['url']=$this->url;

        if(isset($_SESSION['username'])){
            $this->data['username']=$_SESSION['username'];
        }
        elseif(isset($_POST['username'])){
            $this->data['username']=$_POST['username'];
        }
        else{
            $this->data['username']='';
        }

        if(isset($_SESSION['password'])){
            $this->data['password']=$_SESSION['password'];
        }
        elseif(isset($_POST['username'])){
            $this->data['password']=$_POST['password'];
        }
        else{
            $this->data['password']='';
        }
    }

    public function __construct($url){
        $this->url = $url;
    }

}</code>
<p>As you'll know by now <code>start()</code> is used to prepare the data for the view. (Which is <code>loginView</code> as can be seen in <code>getView()</code>.) In this case it gets the credentials from session or post to prefill the form. </p>
<h3>The Login View</h3>
Finally, to tie things together, I present <code>loginView</code>.
<code class="microlight">&#91;&#91; $this->inherit($mainView); &#93;&#93;
&#91;: block content :&#93;

&lt;h2>Please log in&lt;/h2>
&lt;form method="post" action="&#123;&#123;$base&#125;&#125;&#123;&#123;$url&#125;&#125;">

	&lt;label>Username&lt;/label>
	&lt;input type="text" value="&#123;&#123;$username&#125;&#125;" name="username" required />

	&lt;label>Password&lt;/label>
	&lt;input type="password" value="&#123;&#123;$password&#125;&#125;" name="password"  required />
	&lt;br>
	&lt;button type="submit" name="submit-login">Ok&lt;/button>

    @if(isset($error)):
	    &lt;div class="error-msg">&#123;&#123;$error&#125;&#125;&lt;/div>
	@endif;
&lt;/form>
&#91;: endblock :&#93;
</code>
<p>Note the use of variables. For the <code>action</code> attribute the <code>$url</code> variable is used. This is the url as requested by the user. Although this url is always passed to the <em>unauthCallback</em> by the <code>Pilot</code> we still had to pass it to the view in <code>LoginCtrl</code>. Note as well how I prefixed it with <code>$base</code> to get a full url. <code>$base</code> is always available in a FlightControl view.</p>
<p>The <code>value</code> attributes of the input fields refer to variables filled by the controller as well.</p>
<p></p>
<h3>On logging out</h3>
<p><em>Logout</em> is an example of a controller without a view, so since it doesn't have a view I'll explain it in this view. Sometimes a controller doesn't need a view. In the case of logout you <em>could</em> show a view telling you <q>You are logged out</q> but that would be a bit weird.. In FlightControl if a controller does not have a view it needs to tell <code>Pilot</code> where to redirect to. <code>BaseCtrl</code> has a method called <code>getRedirect()</code> which you need to override in your viewless controller.
</p>

<p>If we look at the <code>LogoutCtrl</code> example..</p>
<code class="microlight">class LogoutCtrl extends BaseCtrl{

    private $redirect;

    public function getRedirect(){
        return $this->redirect;
    }

    public function start(){
        $_SESSION['username']='';
        $_SESSION['password']='';
        $_SESSION['loggedin']=false;
    }

    public function __construct($redirect){
        $this->redirect = $redirect;
    }

}
</code>
<p>In <code>start()</code> the actual logging out takes place by emptying the session variables. </p>
<p>Also note it does not override the <code>getView()</code> method. It <em>does</em> implement <code>getRedirect()</code>. The value returned should be the <em>route</em> which Flight will then try to match. In the example the name of the route is not hardcoded but passed throught the constructor as can be seen in the route definition below.</p>
<code class="microlight">Flight::route('/logout', function(){
    Flight::fly(new LogoutCtrl('/'));
});
</code>
<p><code>Pilot</code> only refers to <code>getRedirect</code> when it got no view as <code>fly()</code> parameter and the controller's doesn't provide a view either. If at this point no redirection is returned <code>Pilot</code> throws an exception since it has no way of knowing where to go..</p>

<h3>Final notes</h3>
<p>Note how this example is session based, <code>$_SESSION</code> is used. Somewhere a session must be started. You'll find it in <code>index.php</code>. Using a session is just one way to overcome the statelessness of HTTP. As mentioned before the approach explained on this page is just an example. It's all up to you..</p>
</div>
[: endblock :]