#!/usr/bin/env python

from django.core.urlresolvers import reverse
from django.test import TransactionTestCase
from django.test.client import Client

from panda.models import UserProxy
from panda.tests import utils

class TestUserAdmin(TransactionTestCase):
    fixtures = ['init_panda.json', 'test_users.json']

    def setUp(self):
        self.user = utils.get_panda_user()
        
        self.client = Client()
        self.client.login(username='panda@pandaproject.net', password='panda')

    def tearDown(self):
        self.client.logout()

    def test_add_user(self):
        # Test fetching the form
        response = self.client.get(reverse('admin:panda_userproxy_add'))
        
        self.assertEqual(response.status_code, 200)

        new_user = {
            'email': 'foo@bar.com',
            'last_name': 'Barman'
        }

        # Test submitting the form
        response = self.client.post(reverse('admin:panda_userproxy_add'), new_user)

        self.assertEqual(response.status_code, 302)

        created_user = UserProxy.objects.get(username='foo@bar.com')
        self.assertEqual(created_user.last_name, 'Barman')

