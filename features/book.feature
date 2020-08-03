Feature: Book
    Crud (REST) to /v1/books

    Scenario: GET /v1/books5
        When I run GET on "v1/books"
        Then the status code is 200
        And the body is json
        And the count of "data" is 0

