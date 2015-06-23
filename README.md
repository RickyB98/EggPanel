# EggPanel
<p>The aim of this project is to create a web interface for the famous IRC bot, Eggdrop.<br>
The idea is to create a connection between a MySQL database, an Eggdrop bot and a web server in order to make them communicate and send commands to one another.</p>
<p>Here's how the bot receives commands from the web interface:
<ol>
<li>The web interface writes a record into the MySQL database containing the command and the argument(s) with which the command should be executed.</li>
<li>Every X seconds, the bot connects to an API server over HTTPS and fetches the actions that were not executed yet.</li>
<li>The bot interprets the command(s) and performs said actions.</li>
<li>The bot sends to the API a result message. The API automatically marks the action as executed.</li>
<li>The user checks the logs from the web interface to know if the action was correctly executed.</li>
</ol>
</p>
<p>The platform is intended to be multiuser. This means that each record in the database will have references to the bot in question, which has references to the user owning the bot.</p>
<p>The user can generate a key for its bot(s) from the web interface, which is needed to access the API. Said key is encrypted and saved in the database.</p>
<p>No direct connection happens between the bot and the database. Only the API and the website can access the database.</p>
<p>This project is still in development. Though the API is completed, there are tons of sections which still need developing.</p>
<p>Here's a todo list:
<ul>
<li>Develop the dashboard</li>
<li>User registration and login</li>
<li>...</li>
</ul>
</p>
<p>If you wish to contribute and make this happen, feel free to fork the repository and send pull requests and issues.</p>
<p>This project is licensed under GPL v3.0. You can read more about it in the LICENSE file.</p>
