[[ $this->inherit($mainView); ]]
[: block content :]
<h2>Getting started, from scratch</h2>
<p>The FlightControl package you've downloaded or cloned from GitHub contains an example application. I hope these examples will make the FlightControl learning curve less steep. A trade off is that if you want to start from scratch you'll have to delete these examples first. Here's what to delete, keep and maybe change. We'll go from folder to folder.
</p>
<h3>'Base' folder</h3>
<p>
This is the folder where the application is installed, the one with among others <code>index.php</code> in it.
</p>
<p><code>readme.md</code> can be deleted</p>
<p>if your running Apache you'll want to leave the <code>.htaccess</code> file. If you're viewing this in your browser then I assume it is configured right.</p>
<p>You'll always need the <code>index.php</code>. You <em>can</em> use another bootstrap file but then you'll have to change the rewrite rule in your <code>.htaccess</code> file or nginx server configuration. The example <code>index.php</code> contains quite a lot of comments of what you might need and what not. I advice you to read these and follow along.</p>
<p>The folder <code>assets</code> contains only stuff for the examples and can be deleted. Maybe you want separate folders for images, javascript and fonts, up to you.</p>

<h3>safe folder</h3>
<p><code>mappings.php</code> contains the mappings of FlightControl methods and registration of FlightControl classes. You don't have to put this in this separate file (which is included in <code>index.php</code> but it's probably a good idea. If you don't delete this file otherwise, like <code>index.php</code> this file contains a lot of useful comments. To get Flight working correctly you'll need to map the <code>base()</code>, <code>render()</code> and <code>fly()</code> methods. You'll also need to register <code>view</code>, the view handler. You'll only need to register <code>module</code>, the module loader, if you use FlightControl modules.
</p>
<p>
<code>routes.php</code>, like <code>mappings.php</code> you don't need to put routes in a separate file but it is recommended and let's assume you do, you can probably remove all routes since they're all for the examples. Fill it with your own routes next.
</p>
<p>The <code>.htaccess</code> in the safe folder is what makes this folder 'safe', it contains a simple <code>deny from all</code>. If you're not running on Apache throw away this file and you'll have to figure out how to get the same effect.
</p>

<h3>safe/classes folder</h3>
<p>Keep this folder, it's the FlightControl core.</p>
<h3>safe/controllers folder</h3>
<p>These are all examples controllers. Feel free to remove them.</p>

<h3>safe/modules folder</h3>
<p>Delete this folder unless you do use modules and decided to store them in this folder. If you do use modules but want to store them somewhere else then don't forget to change the initialization of the module loader. In the example application this happens in <code>mappings.php</code>.</p>
<code class="microlight">Flight::register('module','ModLoader',['safe/modules',function($dir){Flight::path($dir);}]);
</code>
<p>The third parameter of register is an array of contructor parameters for (in this case) <code>ModLoader</code>. The first of these is the name of the modules folder, relative to the bootstrap file.</p>
<h3>safe/views folder</h3>
<p>Like <code>controllers</code> these are all examples and can be removed. If your new <em>main template file</em> is not called <code>layout.tpl</code> then don't forget to change the view initialization. In <code>mappings.php</code> (or where ever you moved it to) you'll see these lines:
</p>
<code class="microlight">Flight::register('view', 'Templum', ['safe/views'], function($view){
    $view->setAutoEscape(true);
    $view->setVar('mainView','layout'); // <== ***CONFIG*** name of the mainview
    $view->setVar('base',Flight::base());
    $view->setVar('active','');
});
</code>
<p>Note the line with <code>setVar('mainview','layout')</code>, that's where the mainview's name is set.</p>

[: endblock :]