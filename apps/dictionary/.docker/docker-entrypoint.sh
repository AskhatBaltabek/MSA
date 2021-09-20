#!/bin/sh
#set -e

# Enable Laravel schedule
#if [[ "${ENABLE_CRONTAB:-0}" = "1" ]]; then
#  mv -f /etc/supervisor.d/cron.conf.default /etc/supervisor.d/cron.conf
#  echo "* * * * * php /var/www/dictionary/artisan schedule:run >> /dev/null 2>&1" >> /etc/crontabs/www-data
#fi

exec "$@"

exec supervisord -n -c /etc/supervisord.conf
