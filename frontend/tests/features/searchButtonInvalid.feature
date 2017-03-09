Feature: Search artist when there is no input
  Scenario: Search artist invalid
    Given I am on localhost/index.html
    And I do not input an artist
    When I click on searchButton
    Then I see no difference
    And the searchButton is disabled
