#!/bin/sh

# set up Selenium for functional tests

wget --max-redirect=1 http://goo.gl/cvntq5 -O selenium.jar

java -jar selenium.jar &
