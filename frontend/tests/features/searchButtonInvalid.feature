Feature: Search artist when there is no input
  Scenario: Search artist invalid
    Given I am on localhost/index.html
    And I do not input an artist
    When I press the search button
    Then I see no difference
