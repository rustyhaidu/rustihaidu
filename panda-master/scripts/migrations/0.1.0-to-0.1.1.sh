#!/bin/bash

# PANDA Project migration script to ugprade version 0.1.0 to version 0.1.1.
# Must be executed with sudo!

set -x
exec 1> >(tee /var/log/panda-upgrade.log) 2>&1

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
git checkout 0.1.1

# Update Python requirements
pip install -U -r requirements.txt

# Migrate database
sudo -u panda -E python manage.py syncdb --noinput
sudo -u panda -E python manage.py migrate panda 0001 --fake
sudo -u panda -E python manage.py migrate panda

# Regenerate asset
sudo -u panda -E python manage.py collectstatic --noinput

# Install new Solr configuration (backwards compatible)
cp setup_panda/data_schema.xml /opt/solr/panda/solr/pandadata/conf/schema.xml
cp setup_panda/datasets_schema.xml /opt/solr/panda/solr/pandadatasets/conf/schema.xml

# Run new cleanup task and install cron job
sudo -u panda -E python manage.py purge_orphaned_uploads
wget -nv $CONFIG_URL/panda.cron -O /etc/cron.d/panda

# Restart services
service solr start 
service uwsgi start
service nginx start
sudo service celeryd start

echo "PANDA upgrade complete."
