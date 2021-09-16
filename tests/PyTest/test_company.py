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


def test_store():
    r = requests.post(URLS["store_index"], json={"name": COMPANYNAME})
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': COMPANYNAME}


def test_index():
    r = requests.get(URLS["store_index"])
    assert r.status_code == 200
    assert r.json() == [{'id': 1, 'name': COMPANYNAME}]


@pytest.mark.skip()
def test_create():
    pass


def test_show():
    r = requests.get(URLS["update_delete_show"])
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': COMPANYNAME}


@pytest.mark.skip()
def test_edit():
    pass


def test_update_empty_json():
    r = requests.put(URLS["update_delete_show"], json={})
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': COMPANYNAME}


def test_update_with_data():
    newname = "Bob's Fresh Mowers"
    r = requests.put(URLS["update_delete_show"], json={"name": newname})
    assert r.status_code == 200
    assert r.json() == {'id': 1, 'name': newname}


def test_destroy():
    r = requests.delete(URLS["update_delete_show"])
    assert r.status_code == 200
    assert r.json() == {'id': '1', 'deleted': True}
