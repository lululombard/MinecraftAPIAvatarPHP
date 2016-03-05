# Minecraft Front Skin API
A simple PHP API with caching.

Supports 1.8 skins (Steve and Alex)

## Full skin

Without URL rewriting : `<domain>/?u=<username>` or `<domain>/?u=<username>&s=<size>`

With URL rewriting (htaccess) : `<domain>/<username>` or `<domain>/<username>/<size>`

Example : `http://<domain>/lululombard/120`

![alt tag](http://skins.kingdomhills.fr/lululombard/120)

## Only head with helm

Without URL rewriting : `<domain>/face.php?u=<username>` or `<domain>/face.php?u=<username>&s=<size>`

With URL rewriting (htaccess) : `<domain>/face/<username>` or `<domain>/face/<username>/<size>`

Example : `http://<domain>/face/lululombard/120`

![alt tag](http://skins.kingdomhills.fr/face/lululombard/120)

Folder "cache_skins" will automaticaly be created and will store avatars to cache them for one hour.

API originaly made for [KingdomHills.fr](http://kingdomhills.fr/), no rights reserved, MIT licence.

I merged some code from other projects.