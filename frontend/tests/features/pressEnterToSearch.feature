Feature: Perform artist search by pressing the enter key
  Scenario: Click the search button by pressing enter
    Given I am on localhost/index.html
    And I have selected an artist from dropdown
    When I press enter
    Then I see a word cloud
    And the artistLabel is visible
    And the addButton and shareButton are visible
