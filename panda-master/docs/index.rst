==========================================
PANDA: A Newsroom Data Appliance |release|
==========================================

.. warning::

    This documentation is for the version of PANDA **currently under development**. Were you looking for `version 1.1.1 <http://panda.readthedocs.org/en/1.1.1/>`_ documentation?

About
=====

PANDA is your newsroom data appliance. It provides a place for you to store data, search it and share it with the rest of your newsroom.

The PANDA Project is `2011 Knight News Challenge winner <http://www.knightfoundation.org/press-room/press-release/knight-foundation-media-innovation-contest-announc/>`_. The team would like to thank the `Knight Foundation <http://www.knightfoundation.org/>`_ for their generous support of free and open source software for newsrooms.

Logistical support and fiscal agency for PANDA have been provided by `Investigative Reporters and Editors <http://www.ire.org/>`_. Our sincere thanks to them helping make it a reality.

.. note::

    **Are you a reporter?** Documentation for users can be found at the `PANDA Project Cookbook <http://pandaproject.github.com/>`_.

What is PANDA?
==============

PANDA is:

* A place for journalists to store data.
* A search engine for your news data.
* A private archive of your newsworthy datasets.
* :doc:`Extensible <api>`.
* :doc:`Self-hosted <production>`.

PANDA is *not*:

* A publishing system.
* A universal backend for your newsapps.
* A platform for data visualizations.
* A highly structured datastore.
* Software as a Service.

See our :doc:`Frequently Asked Questions (FAQ) <faq>` for much more.

Setup
=====

.. toctree::
    :maxdepth: 1 

    local_development.rst
    production.rst

Configuration
=============

.. toctree::
    :maxdepth: 1

    Domain name (DNS) <dns.rst>
    Email (SMTP) <email.rst>
    Performance <performance.rst>
    Secure connections (SSL) <ssl.rst>
    Using PANDA in non-English languages <i18n.rst>

Administration
==============

.. toctree::
    :maxdepth: 1

    Users <users.rst>
    Categories <categories.rst>
    API keys <api_keys.rst>
    manual_imports.rst

Server maintenance 
==================

.. toctree::
    :maxdepth: 1

    ssh.rst
    ops.rst
    Backups <backups.rst>
    Storage <storage.rst>
    Upgrades <upgrades.rst>

Extending PANDA
===============

.. toctree::
    :maxdepth: 1 

    api_tutorial.rst
    api.rst

* `Source code repository <https://github.com/pandaproject/panda>`_
* `Issue tracker <https://github.com/pandaproject/panda/issues>`_
* `Project wiki <https://github.com/pandaproject/panda/wiki>`_

Authors
=======

.. include:: ../AUTHORS

License
=======

.. include:: ../LICENSE

.. _changelog:

Changelog
=========

.. include:: ../CHANGELOG

Search this documentation
=========================

* :ref:`search`

