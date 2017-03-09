Feature: Returning to word cloud page from song list
  Scenario: Returns to the previous word cloud page from the Song List page.
    Given I am on localhost/songList.html
    When I click on backWordCloud
    Then I see localhost/index.html
