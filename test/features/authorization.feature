Feature: Authorize user
  As an user
  I want to be able to provide my user information
  So that I can authorize myself in Aero.cx

  Scenario: Authorize myself
    Given I have account in Aero.cx with token "AUTH_TOKEN" and sid "SID"
    When I initialize AeroClient with this information
    Then it should be set into the header of the request
