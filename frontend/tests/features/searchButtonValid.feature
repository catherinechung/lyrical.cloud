Feature: Search artist when there is input
  Scenario: Search artist invalid
    Given I am on localhost/index.html
    And I input an artist
    When I press the search button
    Then I see a word cloud
