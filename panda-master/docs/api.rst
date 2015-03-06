=================
API Documentation
=================


The PANDA application is built on top of a REST API that can be used to power custom applications or import/export data in novel ways.

The PANDA API follows the conventions of `Tastypie <https://github.com/toastdriven/django-tastypie>`_ except in important cases where doing so would create unacceptable limitations. If this documentation seems incomplete, refer to Tastypie's page on `Interacting with the API <http://django-tastypie.readthedocs.org/en/latest/interacting.html>`_ to become familiar with the common idiom.

.. note::

    You will probably want to try these URLs in your browser. In order to make them work you'll need to use the ``format``, ``email``, and ``api_key`` query string parameters. For example, if you had a user named panda@pandaproject.net you might append the following query string to any url described on this page::

        ?format=json&email=panda@pandaproject.net&api_key=edfe6c5ffd1be4d3bf22f69188ac6bc0fc04c84b

Unless otherwise specified, all endpoints that return lists support the ``limit`` and ``offset`` parameters for pagination. Pagination information is contained in the embedded ``meta`` object within the response.

Users
=====

User objects can be queried to retrieve information about PANDA users. Passwords and API keys are not included in responses.

.. warning::

    If accessing the API with normal user credentials you will only be allowed to fetch/list users and to update your own data. Superusers can update any user, as well as delete existing users and create new ones. 

Example User object:

.. code-block:: javascript

    {
        date_joined: "2011-11-04T00:00:00",
        email: "panda@pandaproject.net",
        first_name: "Redd",
        id: "1",
        is_active: true,
        last_login: "2011-11-04T00:00:00",
        last_name: "",
        resource_uri: "/api/1.0/user/1/"
    }

Schema
------

::

    GET http://localhost:8000/api/1.0/user/schema/

List
----

::

    GET http://localhost:8000/api/1.0/user/

Fetch
-----

::

    GET http://localhost:8000/api/1.0/user/[id]/

Create
------

New users are created by POSTing a JSON document containing at least the ``email`` property to the user endpoint. Other properties such as ``first_name`` and ``last_name`` may also be set. If a ``password`` property is specified it will be set on the new user, but it will not be included in the response. If ``password`` is omitted and email is enabled the new user will be sent an activation email.

::

    POST http://localhost:8000/api/1.0/user/

    {
        "email": "test@test.com",
        "first_name": "John",
        "last_name": "Doe"
    }

Update
------

PANDA supports updating users via a simulated PATCH verb. To update a user PUT to the user's URL, with ``patch`` as a query string parameter. In the body of your request include only those attributes of the user you want to change.

::

    PUT http://localhost:8000/api/1.0/user/[id]/?patch=true

    {
        "last_name": "My New Last Name"
    }

Tasks
=====

The Task API allows you to access data about asynchronous processes running on PANDA. This data is read-only.

Example Task object:

.. code-block:: javascript

    {
        end: "2011-12-12T15:11:25",
        id: "1",
        message: "Import complete",
        resource_uri: "/api/1.0/task/1/",
        start: "2011-12-12T15:11:25",
        status: "SUCCESS",
        task_name: "panda.tasks.import.csv",
        traceback: null
    }

Schema
------

::

    GET http://localhost:8000/api/1.0/task/schema/

List
----

::

    GET http://localhost:8000/api/1.0/task/

List filtered by status 
-----------------------

List tasks that are PENDING (queued, but have not yet started processing)::

    GET http://localhost:8000/api/1.0/task/?status=PENDING

.. note::

    Possible task statuses are ``PENDING``, ``STARTED``, ``SUCCESS``, ``FAILURE``, ``ABORT REQUESTED`` and ``ABORTED``.


List filtered by date
---------------------

List tasks that ended on October 31st, 2011::

    GET http://localhost:8000/api/1.0/task/?end__year=2011&end__month=10&end__day=31

Fetch
-----

::

    GET http://localhost:8000/api/1.0/task/[id]/

Data Uploads
============

Due to limitations in upload file-handling, it is not possible to create Uploads via the normal API. Instead data files should be uploaded to http://localhost:8000/data_upload/ either as form data or as an AJAX request. Examples of how to upload files with curl are at the end of this section.

Example DataUpload object:

.. code-block:: javascript

    {
        columns: [
            "id",
            "first_name",
            "last_name",
            "employer"
        ],
        creation_date: "2012-02-08T17:50:09",
        creator: {
            date_joined: "2011-11-04T00:00:00",
            email: "user@pandaproject.net",
            first_name: "User",
            id: "2",
            is_active: true,
            last_login: "2012-02-08T22:45:28",
            last_name: "",
            resource_uri: "/api/1.0/user/2/"
        },
        data_type: "csv",
        dataset: "/api/1.0/dataset/contributors/",
        dialect: {
            delimiter: ",",
            doublequote: false,
            lineterminator: "\r\n",
            quotechar: "\"",
            quoting: 0,
            skipinitialspace: false
        },
        encoding: "utf-8",
        filename: "contributors.csv",
        "guessed_types": ["int", "unicode", "unicode", "unicode"],
        id: "1",
        imported: true,
        original_filename: "contributors.csv",
        resource_uri: "/api/1.0/data_upload/1/",
        sample_data: [
            [
                "1",
                "Brian",
                "Boyer",
                "Chicago Tribune"
            ],
            [
                "2",
                "Joseph",
                "Germuska",
                "Chicago Tribune"
            ],
            [
                "3",
                "Ryan",
                "Pitts",
                "The Spokesman-Review"
            ],
            [
                "4",
                "Christopher",
                "Groskopf",
                "PANDA Project"
            ]
        ],
        size: 168,
        title: "PANDA Project Contributors"
    }

Schema
------

::

    GET http://localhost:8000/api/1.0/data_upload/schema/

List
----

::

    GET http://localhost:8000/api/1.0/data_upload/

Fetch
-----

::

    GET http://localhost:8000/api/1.0/data_upload/[id]/

Download original file
----------------------

::

    GET http://localhost:8000/api/1.0/data_upload/[id]/download/

Upload as form-data
-------------------

When accessing PANDA via curl, your email and API key can be specified with the headers ``PANDA_EMAIL`` and ``PANDA_API_KEY``, respectively::

    curl -H "PANDA_EMAIL: panda@pandaproject.net" -H "PANDA_API_KEY: edfe6c5ffd1be4d3bf22f69188ac6bc0fc04c84b" \
    -F file=@test.csv http://localhost:8000/data_upload/

Upload via AJAX
---------------

::

    curl -H "PANDA_EMAIL: panda@pandaproject.net" -H "PANDA_API_KEY: edfe6c5ffd1be4d3bf22f69188ac6bc0fc04c84b" \
    --data-binary @test.csv -H "X-Requested-With:XMLHttpRequest" http://localhost:8000/data_upload/?qqfile=test.csv

.. note::

    When using either upload method you may specify the character encoding of the file by passing it as a parameter, e.g. ``?encoding=latin1``

Update
------

Data uploads may be updated by PUTing new data to the object's endpoint. However, only the ``title`` field is writeable. All other fields are read-only.

Related Uploads
===============

As with Data Uploads, it is not possible to create Uploads via the normal API. Instead related files should be uploaded to http://localhost:8000/related_upload/ either as form data or as an AJAX request. Examples of how to upload files with curl are at the end of this section.

Example RelatedUpload object:

.. code-block:: javascript

    {
        creation_date: "2012-02-08T23:14:35",
        creator: {
            date_joined: "2011-11-04T00:00:00",
            email: "user@pandaproject.net",
            first_name: "User",
            id: "2",
            is_active: true,
            last_login: "2012-02-08T22:45:28",
            last_name: "",
            resource_uri: "/api/1.0/user/2/"
        },
        dataset: "/api/1.0/dataset/master-4/",
        filename: "PANDA.1.png",
        id: "1",
        original_filename: "PANDA.1.png",
        resource_uri: "/api/1.0/related_upload/1/",
        size: 58990,
        title: "PANDA Logo"
    }

Schema
------

::

    GET http://localhost:8000/api/1.0/related_upload/schema/

List
----

::

    GET http://localhost:8000/api/1.0/related_upload/

Fetch
-----

::

    GET http://localhost:8000/api/1.0/related_upload/[id]/

Download original file
----------------------

::

    GET http://localhost:8000/api/1.0/related_upload/[id]/download/

Upload as form-data
-------------------

When accessing PANDA via curl, your email and API key can be specified with the headers ``PANDA_EMAIL`` and ``PANDA_API_KEY``, respectively::

    curl -H "PANDA_EMAIL: panda@pandaproject.net" -H "PANDA_API_KEY: edfe6c5ffd1be4d3bf22f69188ac6bc0fc04c84b" \
    -F file=@README.txt http://localhost:8000/related_upload/

Upload via AJAX
---------------

::

    curl -H "PANDA_EMAIL: panda@pandaproject.net" -H "PANDA_API_KEY: edfe6c5ffd1be4d3bf22f69188ac6bc0fc04c84b" \
    --data-binary @README.txt -H "X-Requested-With:XMLHttpRequest" http://localhost:8000/related_upload/?qqfile=test.csv

Update
------

Related uploads may be updated by PUTing new data to the object's endpoint. However, only the ``title`` field is writeable. All other fields are read-only.

Categories
==========

Categories are referenced by slug, rather than by integer id (though they do have one).

Example Category object:

.. code-block:: javascript

    {
        dataset_count: 2,
        id: "1",
        name: "Crime",
        resource_uri: "/api/1.0/category/crime/",
        slug: "crime"
    }

Schema
------

::

    http://localhost:8000/api/1.0/category/schema/

List
----

When queried as a list, a "fake" category named "Uncategorized" will also be returned. This category includes the count of all Datasets not in any other category. It's slug is ``uncategorized`` and its id is 0, but it can only be accessed as a part of the list.

::

    http://localhost:8000/api/1.0/category/

Fetch
-----

::

    http://localhost:8000/api/1.0/category/[slug]/

Exports
=======

Example Export object:

.. code-block:: javascript

    {
        creation_date: "2012-07-12T14:38:00",
        creator: "/api/1.0/user/2/",
        dataset: null,
        filename: "search_export_2012-07-12T14:38:00.078677+00:00.zip",
        id: "1",
        original_filename: "search_export_2012-07-12T14:38:00.078677+00:00.zip",
        resource_uri: "/api/1.0/export/1/",
        size: 287,
        title: "search_export_2012-07-12T14:38:00.078677+00:00.zip"
    }

Schema
------

::

    http://localhost:8000/api/1.0/export/schema/

List
----

::

    http://localhost:8000/api/1.0/export/

Fetch
-----

::

    http://localhost:8000/api/1.0/export/[id]/

Download
--------

::

    http://localhost:8000/api/1.0/export/[id]/download/

Datasets
========

Dataset is the core object in PANDA and by far the most complicated. It contains several embedded objects describing the columns of the dataset, the user that created it, the related uploads, etc. It also contains information about the history of the dataset and whether or not it is currently locked (unable to be modified). Datasets are referenced by slug, rather than by integer id (though they do have one).

Example Dataset object:

.. code-block:: javascript

    {
        categories: [ ],
        column_schema: [
            {
                indexed: false,
                indexed_name: null,
                max: null,
                min: null,
                name: "first_name",
                type: "unicode"
            },
            {
                indexed: false,
                indexed_name: null,
                max: null,
                min: null,
                name: "last_name",
                type: "unicode"
            },
            {
                indexed: false,
                indexed_name: null,
                max: null,
                min: null,
                name: "employer",
                type: "unicode"
            }
        ],
        creation_date: "2012-02-08T17:50:11",
        creator: {
            date_joined: "2011-11-04T00:00:00",
            email: "user@pandaproject.net",
            first_name: "User",
            id: "2",
            is_active: true,
            last_login: "2012-02-08T22:45:28",
            last_name: "",
            resource_uri: "/api/1.0/user/2/"
        },
        current_task: {
            creator: "/api/1.0/user/2/",
            end: "2012-02-08T17:50:12",
            id: "1",
            message: "Import complete",
            resource_uri: "/api/1.0/task/1/",
            start: "2012-02-08T17:50:12",
            status: "SUCCESS",
            task_name: "panda.tasks.import.csv",
            traceback: null
        },
        data_uploads: [
            {
                columns: [
                    "first_name",
                    "last_name",
                    "employer"
                ],
                creation_date: "2012-02-08T17:50:09",
                creator: {
                    date_joined: "2011-11-04T00:00:00",
                    email: "user@pandaproject.net",
                    first_name: "User",
                    id: "2",
                    is_active: true,
                    last_login: "2012-02-08T22:45:28",
                    last_name: "",
                    resource_uri: "/api/1.0/user/2/"
                },
                data_type: "csv",
                dataset: "/api/1.0/dataset/contributors/",
                dialect: {
                    delimiter: ",",
                    doublequote: false,
                    lineterminator: "
                    ",
                    quotechar: """,
                    quoting: 0,
                    skipinitialspace: false
                },
                encoding: "utf-8",
                filename: "contributors.csv",
                id: "1",
                imported: true,
                original_filename: "contributors.csv",
                resource_uri: "/api/1.0/data_upload/1/",
                sample_data: [
                    [
                        "Brian",
                        "Boyer",
                        "Chicago Tribune"
                    ],
                    [
                        "Joseph",
                        "Germuska",
                        "Chicago Tribune"
                    ],
                    [
                        "Ryan",
                        "Pitts",
                        "The Spokesman-Review"
                    ],
                    [
                        "Christopher",
                        "Groskopf",
                        "PANDA Project"
                    ]
                ],
                size: 168,
                title: "Contributors"
            }
        ],
        description: "",
        id: "1",
        initial_upload: "/api/1.0/data_upload/1/",
        last_modification: null,
        last_modified: null,
        last_modified_by: null,
        locked: false,
        locked_at: "2012-03-29T14:28:02",
        name: "contributors",
        related_uploads: [ ],
        resource_uri: "/api/1.0/dataset/contributors/",
        row_count: 4,
        sample_data: [
            [
                "Brian",
                "Boyer",
                "Chicago Tribune"
            ],
            [
                "Joseph",
                "Germuska",
                "Chicago Tribune"
            ],
            [
                "Ryan",
                "Pitts",
                "The Spokesman-Review"
            ],
            [
                "Christopher",
                "Groskopf",
                "PANDA Project"
            ]
        ],
        slug: "contributors"
    }

Schema
------

::

    GET http://localhost:8000/api/1.0/dataset/schema/

List
----

::
    
    GET http://localhost:8000/api/1.0/dataset/

List filtered by category
-------------------------

::

    GET http://localhost:8000/api/1.0/dataset/?category=[slug]

List filtered by user
---------------------

A shortcut is provided for listing datasets created by a specific user. Simply pass the ``creator_email`` parameter. Note that this paramter can not be combined with a search query or other filter.

::

    GET http://localhost:8000/api/1.0/dataset/?creator_email=[email]

Search for datasets
-------------------

The Dataset list endpoint also provides full-text search over datasets' metadata via the ``q`` parameter.

.. note::

    By default search results are complete Dataset objects, however, it's frequently useful to return simplified objects for rendering lists, etc. These simple objects do not contain the embedded task object, upload objects or sample data. To return simplified objects just add ``simple=true`` to the query.

::

    GET http://localhost:8000/api/1.0/dataset/?q=[query]

Fetch
-----

::

    GET http://localhost:8000/api/1.0/dataset/[slug]/

Create
------

To create a new Dataset, POST a JSON document containing at least a ``name`` property to the dataset endpoint. Other properties such as ``description`` may also be included.

::

    POST http://localhost:8000/api/1.0/dataset/

    {
        "title": "My new dataset",
        "description": "Lets fill this with new data!"
    }

If data has already been uploaded for this dataset, you may also specify the ``data_upload`` property as either an embedded DataUpload object, or a URI to an existing DataUpload (for example, ``/api/1.0/data_upload/17/``). 

If you are creating a Dataset specifically to be updated via the API you will want to specify columns at creation time. You can do this by providing a ``columns`` query string parameter containing a comma-separated list of column names, such as ``?columns=foo,bar,baz``. You may also specify a ``column_types`` parameter which is an array of types for the columns, such as ``column_types=int,unicode,bool``. Lastly, if you want PANDA to automatically indexed typed columns for data added to this dataset, you can pass a ``typed_columns`` parameter indicating which columns should be indexed, such as ``typed_columns=true,false,true``.

Import
------

Begin an import task. Any data previously imported for this dataset will be lost. Returns the original dataset, which will include the id of the new import task::

    GET http://localhost:8000/api/1.0/dataset/[slug]/import/[data-upload-id]/

Export
------

Exporting a dataset is an asynchronous operation. To initiate an export you simple need to make a GET request. The requesting user will be emailed when the export is complete::

    GET http://localhost:8000/api/1.0/dataset/[slug]/export/

You can export only results which match a query by appending the ``q`` querystring parameter. You can export only results after a certain time by appending the ``since`` querystring parameter. These may be combined::

    GET http://localhost:8000/api/1.0/dataset/[slug]/export/?q=John&since=2012-01-01T00:00:00

Reindex
-------

Reindexing allows you to add (or remove) typed columns from the dataset. You initiate a reindex with a GET request and can supply ``column_types`` and ``typed_columns`` fields in the same format as documented above in the section on creating a Dataset.

::

    GET http://localhost:8000/api/1.0/dataset/[slug]/reindex/

Data
========

Data objects are referenced by a unicode ``external_id`` property, specified at the time they are created. This property must be unique within a given ``Dataset``, but does not need to be unique globally. Data objects are accessible at per-dataset endpoints (e.g. ``/api/1.0/dataset/[slug]/data/``). There is also a cross-dataset Data search endpoint at ``/api/1.0/data/``, however, this endpoint can only be used for search--not for create, update, or delete. (See below for more.)

.. warning::

    The ``external_id`` property of a Data object is the only way it can be referenced via the API. In order to work with Data via the API you **must** include this property at the time you create it. By default this property is ``null`` and the Data can not be accessed except via search.

An example Data object with an ``external_id``:

.. code-block:: javascript

    {
        "data": [
            "1",
            "Brian",
            "Boyer",
            "Chicago Tribune"
        ],
        "dataset": "/api/1.0/dataset/contributors/",
        "external_id": "1",
        "resource_uri": "/api/1.0/dataset/contributors/data/1/"
    }

An example ``Data`` object **without** an ``external_id``, note that it also has no ``resource_uri``:

.. code-block:: javascript

    {
        "data": [
            "1",
            "Brian",
            "Boyer",
            "Chicago Tribune"
        ],
        "dataset": "/api/1.0/dataset/contributors/",
        "external_id": null,
        "resource_uri": null
    }

    
.. warning::

    You can not add, update or delete data in a **locked** dataset. An error will be returned if you attempt to do so.

Schema
------

There is no schema endpoint for Data.

List
----

When listing data, PANDA will return a simplified Dataset object with an embedded ``meta`` object and an embedded ``objects`` array containing Data objects. The added Dataset metadata is purely for convenience when building user interfaces. 

::

    GET http://localhost:8000/api/1.0/dataset/[slug]/data/
    
Search
------

Full-text queries function as "filters" over the normal ``Data`` list. Therefore, search results will be in the same format as the list results described above::

    GET http://localhost:8000/api/1.0/dataset/[slug]/data/?q=[query]

If you have enabled column search for the dataset, you may also specify a ``sort`` query parameter, such as ``column_unicode_name asc`` which would sort the data in ascending order on the ``name`` column. **Note well**, the column names you need to use are not the names from your original dataset, but rather the Solr column names found in the Dataset API as ``indexed_name``. 

For details on searching Data across all Datasets, see below.

Fetch
-----

To fetch a single Data object from a given Dataset::

    GET http://localhost:8000/api/1.0/dataset/[slug]/data/[external_id]/

Create and update
-----------------

Because Data is stored in Solr (rather than a SQL database), there is no functional difference between Create and Update. In either case any Data with the same ``external_id`` will be overwritten when the new Data is created. Because of this requests may be either POSTed to the list endpoint or PUT to the detail endpoint.

An examplew with POST::

    POST http://localhost:8000/api/1.0/dataset/[slug]/data/

    {
        "data": [
            "column A value",
            "column B value",
            "column C value"
        ],
        "external_id": "123456"
    }

An example with PUT::

    PUT http://localhost:8000/api/1.0/dataset/[slug]/data/123456/

    {
        "data": [
            "new column A value",
            "new column B value",
            "new column C value"
        ]
    }

Bulk create and update
----------------------

To create or update objects in bulk you may PUT an array of objects to the list endpoint. Any object with a matching ``external_id`` will be deleted and then new objects will be created. The body of the request should be formatted like::

    {
        "objects": [
            {
                "data": [
                    "column A value",
                    "column B value",
                    "column C value"
                ],
                "external_id": "1"
            },
            {
                "data": [
                    "column A value",
                    "column B value",
                    "column C value"
                ],
                "external_id": "2"
            }
        ]
    }

Delete
------

To delete an object send a DELETE request to its detail url. The body of the request should be empty::

    DELETE http://localhost:8000/api/1.0/dataset/[slug]/data/[external_id]/

Delete all data from a dataset
------------------------------

In addition to deleting individual objects, its possible to delete all Data within a Dataset, by sending a DELETE request to the root per-dataset data endpoint. The body of the request should be empty.

::

    DELETE http://localhost:8000/api/1.0/dataset/[slug]/data/

Global search
=============

Searching all data functions slightly differently than searching within a single dataset. Global search requests go to their own endpoint::

    http:://localhost:8000/api/1.0/data/?q=[query]

The response is a ``meta`` object with paging information and an ``objects`` array containing simplified Dataset objects, each of which contains its own ``meta`` object and an ``objects`` array containing Data objects. **Each Dataset contains a group of matching Data.**

When using this endpoint the ``limit`` and ``offset`` parameters refer to the Datasets (that is, the **groups**) returned. If you wish to paginate the result sets within each group you can use ``group_limit`` and ``group_offset``, however, this is rarely useful behavior.

Exporting global search results
===============================

You may export any set of search results to a zip file by passing ``export=true`` in the querystring. The ``limit``, ``offset``, ``group_limit`` and ``group_offset`` parameters will be ignored for export.

This is an asynchronous operation which will return success or failure based on whether the export task was queued. Use the Task API to check its status or the Export API to retrieve the results.

