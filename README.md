# Minecraft Front Skin API
A simple PHP API with caching.

Supports 1.8 skins (Steve and Alex)

.htaccess is provided for (optionnal) URL rewriting on apache2 (`mod_rewrite` must be enabled via the command `a2enmod rewrite`)

## Full skin

Without URL rewriting : `<domain>/?u=<username>` or `<domain>/?u=<username>&s=<size>`

With URL rewriting (htaccess) : `<domain>/<username>` or `<domain>/<username>/<size>`

Example : `http://<domain>/lululombard/120`

![Example skin](http://skins.kingdomhills.fr/lululombard/120)

## Only head with helm

Without URL rewriting : `<domain>/face.php?u=<username>` or `<domain>/face.php?u=<username>&s=<size>`

With URL rewriting (htaccess) : `<domain>/face/<username>` or `<domain>/face/<username>/<size>`

Example : `http://<domain>/face/lululombard/120`

![Example skin](http://skins.kingdomhills.fr/face/lululombard/120)

## Raw skin

Without URL rewriting : `<domain>/common.php?raw=<username>`

With URL rewriting (htaccess) : `<domain>/raw/<username>`

![Example skin](http://skins.kingdomhills.fr/raw/lululombard)

## More info

Folder "cache_skins" will automaticaly be created and will store avatars to cache them for one hour.

API originaly made for [KingdomHills.fr](http://kingdomhills.fr/), no rights reserved, MIT licence.

I merged some code from other projects.
