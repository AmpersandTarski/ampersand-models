#!/usr/bin/env sh
#
# run this script on the server, with present working directory ~/ampersand-models/RAP3.
# Build the different docker images.
# The first is MariaDB, on which all prototypes are built.
# The seconde is the PHP environment needed for every Ampersand prototype
# The third is the RAP3 system

set -e   ## stops the script upon the first error.

echo "Building RAP3 from ampersandtarski/ampersand-rap"
docker build --file Dockerfile.ampersand-rap --tag ampersandtarski/ampersand-rap ..
