#!/bin/bash

ROOT_DIR="$(cd "$(dirname $0)" && pwd)"/../../..

ln -fs $ROOT_DIR/project/config/production/nginx/tag.conf /etc/nginx/sites-enabled/tag
/usr/sbin/service nginx reload

/bin/bash $ROOT_DIR/project/tool/dep_build.sh link
/usr/bin/php $ROOT_DIR/public/cli.php migrate:install
/usr/bin/php $ROOT_DIR/public/cli.php migrate

ln -fs $ROOT_DIR/project/config/production/supervisor/tag_queue_worker.conf /etc/supervisor/conf.d/tag_queue_worker.conf
/usr/bin/supervisorctl update
/usr/bin/supervisorctl restart tag_queue_worker:*
