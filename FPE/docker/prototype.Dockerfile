ARG PROTOTYPE_IMAGE_VERSION=latest
FROM docker.pkg.github.com/ampersandtarski/prototype/prototype-framework:${PROTOTYPE_IMAGE_VERSION}

ADD . /usr/local/project
# COPY --from=docker.pkg.github.com/ampersandtarski/ampersand-models/siamv4:latest /usr/local/ampersand-models/SIAMv4 /usr/local/project/SIAMv4

ARG DB_HOST=db
ARG SCRIPT=script.adl

# Generate prototype application from folder
RUN ampersand proto /usr/local/project/${SCRIPT} \
      --ignore-invariant-violations \
      --output-directory /var/www \
      --sqlHost ${DB_HOST} \
      --verbose \
      --skip-composer

RUN chown -R www-data:www-data /var/www/log /var/www/data /var/www/generics \
 && cd /var/www \
 # && composer install --prefer-dist --no-dev --profile \
 # && npm install \
 # && gulp build-ampersand \
 # && gulp build-project