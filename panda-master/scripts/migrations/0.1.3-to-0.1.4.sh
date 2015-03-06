#!/bin/bash

# PANDA Project migration script to ugprade version 0.1.3 to version 0.1.4.
# Must be executed with sudo!

set -x
exec 1> >(tee /var/log/panda-upgrade-0.1.4.log) 2>&1

echo "PANDA upgrade beginning."

# Setup environment variables
export DEPLOYMENT_TARGET="deployed"

# Shutdown services
service celeryd stop
service nginx stop
service uwsgi stop
service solr stop

# Install outstanding updates
apt-get --yes update
apt-get --yes upgrade

# Fetch updated source code
cd /opt/panda
git pull
git checkout 0.1.4

# Update Python requirements
pip install -U -r requirements.txt

# Migrate database
sudo -u panda -E python manage.py migrate panda --noinput

# Regenerate assets
sudo -u panda -E python manage.py collectstatic --noinput

# Restart services
service solr start 
service uwsgi start
service nginx start
sudo service celeryd start

# Reindex datasets to get unescaped fields
sleep 15
sudo -u panda -E python manage.py reindex_datasets

echo "PANDA upgrade complete."

