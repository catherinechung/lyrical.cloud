Feature: Clicking on a word will direct to song list page
  Scenario: Shows the song list page for the clicked word
    Given I am on localhost/index.html
    And a word cloud is generated
    When I click on a word
    Then I see localhost/songList.html
    And the songListTitle is word
