#!/usr/bin/env sh
#
# Build the different docker images.
# The first is MariaDB, on which all prototypes are built.
# The seconde is the PHP environment needed for every Ampersand prototype
# The third is the RAP3 system

set -e

echo "Building a MariaDB from ampersandtarski/ampersand-prototype-db"
docker build --file Dockerfile.ampersand-prototype-db --tag ampersandtarski/ampersand-prototype-db .

echo "Building the PHP-environment from ampersandtarski/ampersand-prototype"
docker build --file Dockerfile.ampersand-prototype --tag ampersandtarski/ampersand-prototype .

echo "Building RAP3 from ampersandtarski/ampersand-rap"
docker build --file Dockerfile.ampersand-rap --tag ampersandtarski/ampersand-rap .