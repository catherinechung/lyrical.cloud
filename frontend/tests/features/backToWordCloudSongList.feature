Feature: Returning to word cloud page from song list
  Scenario: Returns to the previous word cloud page from the Song List page.
    Given I am on localhost/songList.html
    When I click the back to word cloud button
    Then I see localhost/index.html
