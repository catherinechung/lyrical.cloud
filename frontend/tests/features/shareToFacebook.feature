Feature: The share button will share the word cloud to Facebook
  Scenario: Share word cloud to Facebook
    Given I am on localhost/index.html
    And a word cloud is generated
    When I click on shareButton
    Then I see a pop up window
