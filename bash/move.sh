#!/bin/bash

# Move the files from the temporary folder
cp -r /var/gpio /sys/class/gpio

# Pause a fraction of a second
perl -e 'select(undef,undef,undef,.1)'

# Move whats currently there back
cp -r /sys/class/gpio /var/gpio