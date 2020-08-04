Feature: Book
    Crud (REST) to /v1/books

    Scenario: Library is empty: GET /v1/books
        When I run GET on "v1/books"
        Then the status code is 200
        And the body is json
        And the count of "data" is 0

  Scenario: Insert a book: POST /v1/books
    When I run POST on "v1/books" with json
"""
{
    "data": {
        "title": "Symfony is awesome",
        "pages": 981
    }
}
"""
    Then the status code is 200
    And the body is json
    And the count of "data" is 1

