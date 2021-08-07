## Clonage du repo - initialisation (si pas de projet sur le pc)
git clone git+ssh://1704607@git.sd3.gpaas.net/sims.gpsnet.fr.git
cd sims.gpsnet.fr
composer install

## rappatrier les donnees du server
git pull gandi master

## push les modifs vers le server
git push gandi master

## execution des scripts de déploiements
ssh 1704607@git.sd3.gpaas.net deploy sims.gpsnet.fr.git