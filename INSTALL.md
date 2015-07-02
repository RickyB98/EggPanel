# Installation guide
## If you haven't set up an Eggdrop yet ...
Please visit http://egghelp.org/ and follow the instructions to set up an Eggdrop bot.
## If you have already set up an Eggdrop ...
### ... and you wish to use http://eggpanel.tk as your panel ...
... then follow the following steps!
<ol>
<li>Open http://eggpanel.tk/signup and create an account.</li>
<li>Follow the steps in the email to complete the registration process.</li>
<li>Add a bot in the dashboard by going to https://eggpanel.tk/dashboard/addbot (login first)</li>
<li>Save the generated API key. <b>Do not lose it! There's no way to get it back!</b></li>
<li>Run the following command as root:<br>
<code># apt-get install tcllib tcl-tls</code></li>
<li>Open the scripts/ folder on this repository and download all the files. Put them in the scripts directory of your bot (usually eggdrop/scripts/).</li>
<li>Rename the file "eggpanel.conf.example" to "eggpanel.conf". You can do so using the command:<br>
<code>mv eggpanel.conf.example eggpanel.conf</code></li>
<li>Edit the file with your favourite editor (nano, vim, gnome, etc.). Here's the command for nano if you're on SSH:<br>
<code>nano eggpanel.conf</code></li>
<li>Paste the API key we generated earlier in eggpanel(key) between the quotes.</li>
<li>Save and close the file. If you're on nano, press CTRL-O, then Enter, then CTRL-X.<br></li>
<li>Open your Eggdrop configuration file (eggdrop.conf).</li>
<li>Navigate to the end of the file and add the following line:<br>
<code>source scripts/eggpanel.tcl</code></li>
<li>If the bot was down, then start it. If it was already running, then login into the partyline and issue a rehash (.rehash).</li>
<li>Go to https://eggpanel.tk/dashboard/ and check that the bot status is "ONLINE".</li>
</ol>
That's it! You can start using the web panel. :)
### ... but you wish to use another website as your panel ...
I'll explain it to you later ;)
