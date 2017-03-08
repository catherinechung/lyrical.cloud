Feature: Adding an artist to the word cloud
  Scenario: Add an invalid artist
    Given I am on localhost/index.html
    And a word cloud is generated
    And I do not input an artist in the search bar
    When I click on add
    Then I see no difference
