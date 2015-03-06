#!/bin/bash

# PANDA Project migration script to ugprade version 0.2.0 to version 1.0.0.
# Must be executed with sudo!

set -x
exec 1> >(tee /var/log/panda-upgrade-1.0.0.log) 2>&1

echo "PANDA upgrade beginning."

# Upgrade to Ubuntu 12.04
do-release-upgrade -d -f DistUpgradeViewNonInteractive

# Setup environment variables
export DEPLOYMENT_TARGET="deployed"

# Shutdown services
service celeryd stop
service nginx stop
service uwsgi stop
service solr stop

# Fetch updated source code
cd /opt/panda
git pull
git checkout 1.0.0

# Update Python requirements
pip install -U -r requirements.txt

# Migrate database
sudo -u panda -E python manage.py migrate panda --noinput

# Re-run django-longerusername for those may have missed it (see #789)
sudo python manage.py migrate longerusername zero --fake
sudo python manage.py migrate longerusername 0001

# Regenerate assets
sudo -u panda -E python manage.py collectstatic --noinput

# Install new Solr configuration
cp setup_panda/data_schema.xml /opt/solr/panda/solr/pandadata/conf/schema.xml
cp setup_panda/english_names.txt /opt/solr/panda/solr/pandadata/conf/english_names.txt
cp setup_panda/datasets_schema.xml /opt/solr/panda/solr/pandadatasets/conf/schema.xml

# Install uwsgi jumpstart configuration
cp setup_panda/uwsgi_jumpstart.conf /etc/init/uwsgi.conf

# Rewrite nginx configuration
# (can't just copy new version since they may have enabled ssl)
sudo sed -i 's/client_max_body_size 1G/client_max_body_size 0/g' /etc/nginx/sites-available/panda

# Restart services
service solr start 
service uwsgi start
service nginx start
sudo service celeryd start

echo "PANDA upgrade complete."

