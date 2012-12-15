MineControl
===========

A MultiServerControl symfony2 bundle for minecraft servers.

How can I test the bundle?
-----------
* Go into the root directory of your symfony project e.g. `cd /var/www/MineControl/`
* Make a directory named 'server' `mkdir server`
* Download the [minecraft server](https://s3.amazonaws.com/MinecraftDownload/launcher/minecraft_server.jar) into the server directory `cd server/` `wget LINK`
* Now call `php app/console minecraft (start|stop|restart|status)`
