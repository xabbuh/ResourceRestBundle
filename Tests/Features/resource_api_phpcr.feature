Feature: PHPCR resource repository
    In order to retrieve data from the resource webservice
    As a webservice user
    I need to be able to query the webservice

    Background:
        Given the test application has the following configuration:
            """
            cmf_resource:
                repositories:
                    phpcr_repo:
                        type: doctrine_phpcr
                        basepath: /tests/cmf/articles

            cmf_resource_rest:
                enhancer_map:
                    -
                        repository: phpcr_repo
                        enhancer: payload
            """


    Scenario: Retrieve PHPCR resource with children
        Given there exists a "Article" document at "/cmf/articles/foo":
            | title | Article 1 |
            | body | This is my article |
        When I send a GET request to "/api/phpcr_repo/foo"
        Then the response should contain json:
            """
            {
                "repository_alias": "phpcr_repo",
                "repository_type": "doctrine_phpcr",
                "payload_alias": null,
                "payload_type": "nt:unstructured",
                "path": "\/foo",
                "node_name": "foo",
                "label": "foo",
                "repository_path": "\/foo",
                "children": []
            }
            """
