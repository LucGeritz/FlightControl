[[ $this->inherit($mainView); ]]
[: block content :]
<h2>This is the <string>odd</string> view</h2>
<p>This view is shown because it was requested at an odd ({{$secs}}) number of seconds.</p>
<p>Your ip is {{$ip}}</p>
<p>Explanation of this controller is on the even page, just <a href="{{$base}}/variable">try again</a>.</p>
[: endblock :]

