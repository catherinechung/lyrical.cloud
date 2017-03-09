Feature: Adding an artist to the word cloud
  Scenario: Add an invalid artist
    Given I am on localhost:8081
    And a word cloud is generated
    And I do not input an artist
    When I click on addButton
    Then I see no difference
    And the addButton is disabled
