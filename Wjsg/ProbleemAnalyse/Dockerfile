FROM ampersandtarski/ampersand-prototype:latest

ENV AMPERSAND_DB_HOST=db

RUN mkdir /src

ADD . /src

# Generate prototype application from folder
RUN ampersand /src/Analyse.adl --verbose --proto=/var/www/html --sqlHost=db --sqlLogin=ampersand --sqlPwd=ampersand \
 && mkdir -p /var/www/html/log \
 && chown -R www-data:www-data /var/www/html

VOLUME /var/www/html/