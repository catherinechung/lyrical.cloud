Feature: Shows word cloud after searching an artist
  Scenario: Generate word cloud
    Given I am on localhost/index.html
    And I input an artist in the search bar
    When I click on search
    Then I see a word cloud
    And the artist name
    And the add and share buttons are visible
