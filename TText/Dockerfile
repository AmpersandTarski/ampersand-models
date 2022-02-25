FROM ampersandtarski/prototype-framework:v1.14

COPY . /usr/local/project/

# Put SIAM templates in right folder
COPY ./modules/ampersandtarski/siam/src/templates/ /usr/local/project/templates/

# Generate prototype application from folder
RUN ampersand proto /usr/local/project/TText.adl \
      --proto-dir /var/www \
      --verbose \
      --ignore-invariant-violations

COPY customizations/ /var/www/

RUN chown -R www-data:www-data /var/www/log /var/www/data /var/www/generics \
 && cd /var/www \
 # uncomment lines below if customizations are added to default prototype framework
 # && composer install --prefer-dist --no-dev --optimize-autoloader --profile \
 # && npm install \
 # && gulp build-ampersand \
 && gulp build-project