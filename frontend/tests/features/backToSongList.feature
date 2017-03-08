Feature: Returning to the song list page from the lyrics page
  Scenario: Returns to the previous song list page from the lyrics page.
    Given I am on localhost/lyrics.html
    When I click the back to song list button
    Then I see localhost/songList.html
