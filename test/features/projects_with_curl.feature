Feature: Manage projects
  As an user
  I want to be able to communicate with Aero.cx from my application
  So that I can manage my projects there

  Background:
    Given I have cURL on my server

  @curl @projects
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

  @curl @projects
  Scenario: Get project with ID
    Given I have created project "Google" with id "1" in Aero.cx
    When I initialize the AeroCLient and want to get this project
    Then I should receive project "Google" with id "1"

  @curl @projects
  Scenario: Create project
    Given I have built a project "Google" with description "Search engine"
    When I initialize the AeroClient and want to save it there
    Then I should receive project "Google" with description "Search engine"

  @curl @projects
  Scenario: Update project
    Given I have created project with id "1"
    When I initialize the AeroClient and want to update it to "Facebook" with description "Meet your friends"
    Then I should receive the updated project "Facebook" with description "Meet your friends"

  @http @projects
  Scenario: Delete project
    Given I have created project with id "1"
    When I initialize the AeroClient and want to delete it
    Then I should receive delete confirmation status
