#! /usr/bin/env python

import pytest
import requests

SERVER="127.0.0.1"
PORT="8000"
BASEURL = "http://{}:{}".format(SERVER, PORT)

COMPANYNAME = "My Company Name"

URLS = {
    "store_index": "{}/api/companies".format(BASEURL),
    "update_delete_show": "{}/api/companies/{}".format(BASEURL, 1)
}

"""
todo: make test results independent of execution order, remove dependencies between tests
"""

def test_store():
    r = requests.post(URLS["store_index"], json={"name": COMPANYNAME})
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': COMPANYNAME}


def test_store_no_data():
    r = requests.post(URLS["store_index"], json={})
    assert r.status_code == 200
    # todo: response can't be decoded as json
    # nothing is being saved to DB
    print(r)


def test_store_extra_data():
    # extra field will be discarded
    r = requests.post(URLS["store_index"], json={"name": COMPANYNAME, "extradata": 1})
    assert r.status_code == 200
    assert r.json() == {'name': COMPANYNAME, 'id': 2}


def test_index():
    r = requests.get(URLS["store_index"])
    assert r.status_code == 200
    assert r.json() == [{'id': 1, 'name': COMPANYNAME},
                        {'id': 2, 'name': 'My Company Name'}]


def test_show():
    r = requests.get(URLS["update_delete_show"])
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': COMPANYNAME}


def test_update_empty_json():
    r = requests.put(URLS["update_delete_show"], json={})
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': COMPANYNAME}


def test_update_with_data():
    newname = "Bob's Fresh Mowers"
    r = requests.put(URLS["update_delete_show"], json={"name": newname})
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': newname}


def test_update_with_extra_data():
    newname = "Jebediah's Corn Beef"
    r = requests.put(URLS["update_delete_show"], json={"name": newname, "extradata": 3})
    assert r.json() == {'id': 1, 'name': newname}


def test_destroy():
    r = requests.delete(URLS["update_delete_show"])
    assert r.status_code == 200
    assert r.json() == {'id': '1', 'deleted': True}
