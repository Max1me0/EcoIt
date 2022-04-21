# EcoIt

symfony new EcoWeb --webapp
cd EcoWeb

symfony server:ca:install
symfony proxy:start
symfony proxy:domain:attach ecoweb

symfony serve

composer require symfony/webpack-encore-bundle
npm install

composer require symfony/maker-bundle --dev

php bin/console doctrine:database:create

npm install bootstrap --save-dev
npm install @popperjs/core --save-dev
npm install sass-loader@^12.0.0 sass --save-dev
npm install

npm run build
npm run watch