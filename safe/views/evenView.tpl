[[ $this->inherit($mainView); ]]
[: block content :]
<h2>This is the <string>even</string> view</h2>
<p>This view is shown because it was requested at an even ({{$secs}}) number of seconds.</p>
<p>Your ip is {{$ip}}</p>
<div class="notes">
<p>An example of a controller with variable views, decided by the controller. It also demonstrates how to pass controller specific paramters. (In this case the <em>ip</em> number.)</p>
<p>The controller <code>VariableCtrl</code> looks like this:</p>
<code class="microlight"">class VariableCtrl extends BaseCtrl{
	
    private $ip; 
	
    public function getView(){
        return ($this->data['secs'] %2 == 0) ? 'evenView' : 'oddView';				
    }

    public function start(){
        $this->data['secs'] = (int)date('s');
        $this->data['ip'] = $this->ip;
    }
	
    public function __construct($ip){
        $this->ip = $ip;
    }
		
}
</code>
<p>Just like in the <a href="{{$base}}/simple">SimpleCtrl</a> the data array <code>$this->data</code> is set in the <code>start()</code> method. Nothing new here..</p>
<p>More interesting is <code>getView()</code> method. The controller decides based on available data which view is needed. Either <code>oddView</code> or <code>evenView</code> depending on the exact time the request was made. (Ok, actually the exact time <code>start()</code> got executed.</p>
<p>Finally we see how easy it is to pass controller specific parameters. Just create a constructor method and pass it to there. See the route definition:</p>
<code class="microlight">Flight::route('/variable', function(){
	Flight::fly(new VariableCtrl(Flight::request()->ip));
});
</code>
<p>Note how the ip address (as provided by <code>Flight::request</code>) is passed to the constructor.</p>


</div>
[: endblock :]

