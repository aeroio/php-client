Feature: Manage projects
  As an user
  I want to be able to communicate with Aero.cx from my application
  So that I can manage my projects there

  Scenario: Get all projects
    Given I have created the following projects in Aero.cx:
      | Google   |
      | Twitter  |
      | Facebook |
    When I initialize the AeroClient and want to get all of my projects
    Then I should receive the following projects:
      | Google   |
      | Twitter  |
      | Facebook |

  Scenario: Get project with ID
    Given I have created project "Google" with id "1" in Aero.cx
    When I initialize the AeroCLient and want to get this project
    Then I should receive project "Google" with id "1"
