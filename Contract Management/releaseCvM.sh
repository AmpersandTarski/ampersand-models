# Run this script from the server to overwrite CvM with its latest release. 
# Precondition: CvM is running in its container, called ${rap3container}.
# Postcondition: the latest release of CvM from repo https://github.com/AmpersandTarski/ampersand-models/CvM is running in its container.

docker cp ./releaseCvMwithinContainer.sh $(docker-compose ps -q rap3):/tmp/releaseCvMwithinContainer.sh
docker-compose exec rap3 sh -c "/tmp/releaseCvMwithinContainer.sh"
docker-compose exec rap3 sh -c "rm /tmp/releaseCvMwithinContainer.sh"
