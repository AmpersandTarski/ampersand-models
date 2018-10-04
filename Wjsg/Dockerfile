FROM ampersandtarski/ampersand-prototype:texlive

ENV AMPERSAND_DB_HOST=db

RUN mkdir /src

ADD . /src

# Generate prototype application from folder
RUN ampersand --proto=/var/www/html /src/JustGegevens.adl --verbose --sqlHost=db --sqlLogin=ampersand --sqlPwd=ampersand \
 && mkdir -p /var/www/html/log \
 && chown -R www-data:www-data /var/www/html

VOLUME /var/www/html/
