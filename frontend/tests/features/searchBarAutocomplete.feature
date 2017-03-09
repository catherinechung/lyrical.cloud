Feature: Autocomplete artist suggestions
  Scenario: Load artist suggestions
    Given I am on localhost/index.html
    When I input more than three letters in the automplete-1
    Then I see a dropdown
