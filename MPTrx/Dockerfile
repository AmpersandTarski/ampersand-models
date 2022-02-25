FROM ampersandtarski/prototype-framework:v1.14

COPY . /usr/local/project/

# Generate prototype application from folder
RUN ampersand proto /usr/local/project/MPTrx.adl \
      --proto-dir /var/www \
      --verbose \
      --ignore-invariant-violations

COPY customizations/ /var/www/

RUN chown -R www-data:www-data /var/www/log /var/www/data /var/www/generics \
 && cd /var/www \
 # uncomment lines below if customizations are added to default prototype framework
 && composer install --prefer-dist --no-dev --optimize-autoloader --profile \
 && npm install \
 && gulp build-ampersand \
 # end of lines to be uncommented
 && gulp build-project