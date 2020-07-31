Feature: Book
    Crud (REST) to /v1/books

    Scenario: GET /v1/books
#    Given there is a "Sith Lord Lightsaber", which costs £5
        When I run GET on "v1/books"
        Then the status code is 200
        And the body is json

