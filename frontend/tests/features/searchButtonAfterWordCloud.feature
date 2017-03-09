Feature: Searches a new artist after a word cloud is generated
  Scenario: Search an artist after already having a word cloud
    Given I am on localhost/index.html
    And there is a word cloud
    When I input an artist
    And I press the searchButton
    Then I see a word cloud
    And artistLabel is filled
