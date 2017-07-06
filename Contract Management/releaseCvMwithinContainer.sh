# Run this script to overwrite CvM with its latest release. 

echo "creating new instance of CvM"
cd ~/git/Ampersand-models
git pull
ampersand --verbose -p/var/www/html/CvM Contract\ Management/CvM.adl
chown -R www-data:www-data /var/www/html/CvM
