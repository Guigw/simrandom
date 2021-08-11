## Clonage du repo - initialisation (si pas de projet sur le pc)
git clone git@github.com:Guigw/simrandom.git
cd simrandom
composer install
yarn install

## creation des routes d'api
java -jar [open-api-generator-cli] -i config/simrandom.api.json generate -g typescript -c config/openapi/config.json -o assets/gen

## build webpack
npx webpack --config webpack.config.js (--env production)

## rappatrier les donnees du server
git pull

## push les modifs vers le server
git push

## execution des scripts de déploiements
