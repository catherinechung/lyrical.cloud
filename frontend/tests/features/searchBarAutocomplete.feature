Feature: Autocomplete artist suggestions
  Scenario: Load artist suggestions
    Given I am on localhost/index.html
    When I input more than three letters in the search bar
    Then I see a dropdown menu
