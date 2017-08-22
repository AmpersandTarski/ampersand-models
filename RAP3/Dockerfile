FROM ampersandtarski/ampersand-prototype:texlive

# This environment variable is used in localSettings.php and localSettingsProduction.php
ENV AMPERSAND_DB_HOST=db

# Add required directories
RUN mkdir /ampersand-models
ADD SIAM /ampersand-models/SIAM
ADD RAP3 /ampersand-models/RAP3
ADD Sequences /ampersand-models/Sequences

# Generate prototype application from folder
RUN ampersand -V --proto=/var/www/html --meta-tables --add-semantic-metamodel /ampersand-models/RAP3/RAP3.adl \
 && mkdir -p /var/www/html/log \
 # use Production settings
 && mv /ampersand-models/RAP3/include/localSettingsProduction.php /var/www/html/localSettings.php \
 && chown -R www-data:www-data /var/www/html
