Feature: Shows word cloud after searching an artist
  Scenario: Generate word cloud
    Given I am on localhost/index.html
    And I input an artist in the automplete-1
    When I click on searchButton
    Then I see a word cloud
    And artistLabel is filled 
    And the addButton and shareButton are visible
