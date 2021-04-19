web: vendor/bin/heroku-php-apache2 public/
base: composer install && php bin/console cache:clear && php bin/console cache:warmup && php bin/console d:d:c && php bin/console d:m:m
