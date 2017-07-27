#!/usr/bin/env sh
#
# Build the different docker images.
# The first is MariaDB, on which all prototypes are built.
# The seconde is the PHP environment needed for every Ampersand prototype
# The third is the RAP3 system

set -e   ## stops the script upon the first error.

echo "Building RAP3 from ampersandtarski/ampersand-rap"
docker build --file Dockerfile.ampersand-rap --tag ampersandtarski/ampersand-rap ..
