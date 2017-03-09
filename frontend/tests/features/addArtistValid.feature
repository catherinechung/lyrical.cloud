Feature: The add button will add an artist to the word cloud
  Scenario: Add an artist
    Given I am on localhost/index.html
    And a word cloud is generated
    And I input an artist
    When I click on addButton
    Then I see a word cloud
    And there are two artist names
