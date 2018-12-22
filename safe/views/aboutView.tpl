[[ $this->inherit($mainView); ]]
[: block content :]
<p style="text-align:center;">FlightControl is made by TIGREZ / Luc Geritz</p>

	<div class="image">
		<img src="assets/tigrez.png">
	</div>
<p style="text-align:center;">TIGREZ is an anagram for Geritz, <em>Luc Geritz</em>. A Web Developer who likes writing code for the sake of coding, thinks the letters OO stand for c-OO-l and feels strong about PHP not being an excuse to write sloppy code.</p>
	<div class="image">
		<img src="assets/fclogo-small.jpg">
	</div>
<p style="text-align:center;">FlightControl v[[echo Flight::get('fc_version');]]</p>

<div class="image">
		<img src="assets/basedon.jpg">
</div>
<p style="text-align:center;">FlightControl is based on <a href="http://flightphp.com/">Flight</a>. A PHP framework which I recommend for its simpleness and elegance! All credits go to Flight, I just added my one percent..</p>
<div class="image">
		<span style="font-size: 1.8rem; color:darkblue; font-family: monospace;">&#91;&#91;echo 'TEMPLUM';&#93;&#93;</span>
</div>
<p style="text-align:center;">FlightControl uses the <a href="https://github.com/fboender/templum">Templum template engine</a> by F.Boender. Just like Flight Templum is fast and small. Templum has been around for a while but good algorithms do not age. It comes with built-in XSS protection!</p>

<div class="image">
		<span style="text-shadow: 0px 0px 9px rgba(5, 44, 54,0.7), 0px 0px 2px rgba(5, 44, 54,0.4); font-size:1.8rem;">microlight.js</span>
</div>
<p style="text-align:center;">For the code examples I use <a href="http://asvd.github.io/microlight/">microlight.js</a>. Even its name fits in the aviation theme of FlightControl :) Its <em>colorless highlight</em> might take some time to get used to.. But I love it!</p>
[: endblock :]
