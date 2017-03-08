Feature: Clicking on a song will transition to the lyrics page
  Scenario: Shows the lyrics page for the clicked song
    Given I am on localhost/songList.html
    When I click on a song
    Then I see localhost/lyrics.html
    And the word is highlighted
