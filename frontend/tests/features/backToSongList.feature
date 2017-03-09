Feature: Returning to the song list page from the lyrics page
  Scenario: Returns to the previous song list page from the lyrics page.
    Given I am on localhost/lyrics.html
    When I click on backSongList
    Then I see localhost/songList.html
