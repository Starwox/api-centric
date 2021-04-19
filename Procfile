web: vendor/bin/heroku-php-nginx public/
base: composer install && php bin/console cache:clear && php bin/console cache:warmup
bdd: php bin/console d:d:c && php bin/console d:m:m
