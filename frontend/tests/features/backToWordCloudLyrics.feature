Feature: Returning to word cloud page from lyrics
  Scenario: Returns to the previous word cloud page from the lyrics page.
    Given I am on localhost/lyrics.html
    When I click the back to word cloud button
    Then I see localhost/index.html
