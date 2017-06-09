Feature: Greeting
In order to see a greeting message
As a website user
I need to be able to view the homepage

    Scenario: Greeting on the home page
        Given I am on "/"
        Then I should see "Laravel"

    Scenario: Greeting on the login page
        Given I am on "/login"
        Then I should see "Login"
