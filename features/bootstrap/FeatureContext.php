<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /** @Given /^I am on the "([^"]*)"$/ */
    public function iAmOnThe($dir)
    {
        echo 'ok';
    }

    /** @And /^I have a file named "([^"]*)"$/ */
    public function iHaveAFileNamed($dir)
    {
        echo 'ok';
    }
}
