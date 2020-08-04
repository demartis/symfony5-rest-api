Feature: Book
    Crud (REST) to /v1/books

    Scenario: Library is empty: GET /v1/books
        When I run GET on "v1/books"
        Then the status code is 200
        And the body is json
        And the count of "data" is 0

  Scenario: Insert a book: POST /v1/books
    When I run "POST" on "v1/books" with json
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

  Scenario: Modify a book: PUT /v1/books/1
    When I run "PUT" on "v1/books/1" with json
"""
{
    "data": {
        "title": "PHP is awesome",
        "pages": 1000
    }
}
"""
    Then the status code is 200
    And the body is json
    And the count of "data" is 1
    And json body have "$.data.title" = "PHP is awesome"
    And json body have "$.data.pages" = "1000"

