#! /usr/bin/env python

import pytest
import requests

SERVER="127.0.0.1"
PORT="8000"
BASEURL = "http://{}:{}".format(SERVER, PORT)

URLS = {
    "store_index": "{}/api/employees".format(BASEURL),
    "update_delete_show": "{}/api/employees/{}".format(BASEURL, 1)
}


def test_store():
    data = {'firstname': 'Billy',
            'lastname': 'Bob',
            'dob': '12 May 1945',
            'email': 'foo@bar.com',
            'company_id': 2}

    r = requests.post(URLS["store_index"], json=data)
    assert r.status_code == 200
    assert r.json() == {'firstname': 'Billy',
                        'lastname': 'Bob',
                        'dob': '12 May 1945',
                        'email': 'foo@bar.com',
                        'company_id': 2,
                        'id': 1,
                        'company': {'id': 2,
                                    'name': 'My Company Name'}}


def test_index():
    r = requests.get(URLS["store_index"])
    assert r.status_code == 200
    assert r.json() == [{'firstname': 'Billy',
                        'lastname': 'Bob',
                        'dob': '12 May 1945',
                        'email': 'foo@bar.com',
                        'company_id': 2,
                        'id': 1}]


def test_show():
    r = requests.get(URLS["update_delete_show"])
    assert r.status_code == 200
    assert r.json() == {'firstname': 'Billy',
                        'lastname': 'Bob',
                        'dob': '12 May 1945',
                        'email': 'foo@bar.com',
                        'company_id': 2,
                        'id': 1}


def test_update():
    data = {'firstname': 'Jim',
            'lastname': 'Joe',
            'dob': '12 May 1942'}
    returned = {'id': 1,
                'email': "foo@bar.com",
                'company_id': 2,
                'company': {'id': 2,
                            'name': 'My Company Name'}}
    returned.update(data)

    r = requests.put(URLS["update_delete_show"], json=data)
    assert r.status_code == 200
    assert r.json() == returned


def test_update_with_company():
    # setup - create new company
    newco = "{}/api/companies".format(BASEURL)
    r = requests.post(newco, json={'name': 'Best Fish N Chips'})
    company_id = r.json()["id"]

    data = {'firstname': 'Jim',
            'lastname': 'James',
            'email': 'bar@baz.com',
            'company_id': company_id}
    returned = {'company': {'id': 3,
                            'name': 'Best Fish N Chips'},
                'id': 1,
                'dob': '12 May 1942',}
    returned.update(data)

    r = requests.put(URLS["update_delete_show"], json=data)
    assert r.status_code == 200
    assert r.json() == returned


def test_destroy():
    r = requests.delete(URLS["update_delete_show"])
    assert r.status_code == 200
    assert r.json() == {'id': '1', 'deleted': True}
