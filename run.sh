#!/bin/bash

DOCKER_USERNAME=lbaw2014 # Replace by your docker hub username
IMAGE_NAME=lbaw2014

docker run -it -p 8000:80 $DOCKER_USERNAME/$IMAGE_NAME