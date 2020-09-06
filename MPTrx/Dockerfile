FROM ampersandtarski/prototype-framework:development

COPY . /usr/local/project/

# COPY --from=docker.pkg.github.com/ampersandtarski/ampersand-models/siamv4:latest /usr/local/ampersand-models/SIAMv4/ /usr/local/project/SIAMv4/

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