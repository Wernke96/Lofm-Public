#!/usr/bin/env bash
    while [ true ]
do
  php artisan queue:work --verbose --tries=3 --timeout=90
  sleep 60
done
    # Run queue
