Feature: The add button will add an artist to the word cloud
  Scenario: Add an artist
    Given I am on localhost/index.html
    And a word cloud is generated
    And I input an artist in the search bar
    When I click on addButton
    Then I see an updated word cloud
    And there are two artist names
