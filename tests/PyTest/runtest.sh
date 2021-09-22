#! /bin/bash

php ../../artisan migrate:fresh
php ../../artisan serve &
artisanpid=$!
echo Started server at PID $artisanpid

sleep 1

pytest -s -q test_company.py
pytest -s -q test_employee.py

pkill -P $artisanpid
kill $artisanpid
echo Killed $artisanpid and its children

echo Sanity check:
ps -ef | grep php
