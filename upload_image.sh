#!/bin/bash

# Stop execution if a step fails
set -e

DOCKER_USERNAME=lbaw2014 				# Replace by your docker hub username
IMAGE_NAME=lbaw2014                 # Replace with your group's image name

# Ensure that dependencies are available
composer install
php artisan clear-compiled

docker build -t $DOCKER_USERNAME/$IMAGE_NAME .
docker push $DOCKER_USERNAME/$IMAGE_NAME
