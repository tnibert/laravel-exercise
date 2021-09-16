#! /bin/bash

php ../../artisan migrate:fresh
php ../../artisan serve &
artisanpid=$!
echo Started server at PID $artisanpid

pytest -s -q test_company.py
pytest -s -q test_employee.py

kill $artisanpid
echo Killed $artisanpid
