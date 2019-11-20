FROM ampersandtarski/ampersand-prototype:latest

ARG ADL_FILE
ENV ADL_FILE=${ADL_FILE:-Temporal.adl}

ENV AMPERSAND_DB_HOST=db

RUN mkdir /src

ADD . /src

# Generate prototype application from folder
RUN ampersand --proto=/var/www/html /src/Temporal.adl --verbose --sqlHost=db --sqlLogin=ampersand --sqlPwd=ampersand \
 && mkdir -p /var/www/html/log \
 && chown -R www-data:www-data /var/www/html