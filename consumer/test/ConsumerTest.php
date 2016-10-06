<?php

use Pact\Phpacto\Service\PactProviderService;


/**
 * Class ConsumerTest
 * Implements the consumer driven contracts that will be published.
 */
class ConsumerTest extends PHPUnit_Framework_TestCase
{

    private static $providerService;
    private $svc;

    /**
     * @beforeClass
     */
    public static function setUpTestFixture()
    {
        if (is_null(self::$providerService)) {
            self::$providerService = new PactProviderService(CONTRACT_OUTPUT);
            self::$providerService->ServiceConsumer("Consumer")->HasPactWith("Provider");
        }
    }

    /**
     * @afterClass
     */
    public static function tearDownTestFixture()
    {
        self::$providerService->WriteContract();
    }

    public function setUp()
    {
        if (!is_null(self::$providerService)) {
            $this->svc = self::$providerService;
        }
    }

    public function tearDown()
    {
        $this->svc->Stop();
    }

    public function testGetCollaboratorWithID()
    {

        $request = array(
                "headers" => array("Accept" => "application/json"),
                "method" => "GET",
                "path" => "/collaborators/23"
        );

        $expectedResponse = array(
                "body" => array(
                        "name" => "John",
                        "role" => "Client Relantionship"
                ),
                "headers" => array(
                        "Content-Type" => "application/json"
                ),
                "status" => 200
        );

        // Arrange
        $this->svc
                ->Given("there is a collaborator with id 23")
                ->UponReceiving("get collaborator")
                ->With($request)
                ->WillRespond($expectedResponse);

        // Act
        $actualResponse = $this->svc->Start();

        // Assert
        $actualResponseBody = json_decode((string)$actualResponse->getBody(), true);
        $this->assertEquals($expectedResponse['body'], $actualResponseBody);
    }

    public function testCreateNewCollaboratorAsDeveloperRole()
    {

        $request = array(
                "headers" => array("Accept" => "application/json"),
                "method" => "POST",
                "path" => "/collaborators",
                "body" => array("username" => "daniele", "role" => "developer")
        );

        $expectedResponse = array(
                "body" => array(
                        "username" => "daniele",
                        "role" => "developer"
                ),
                "headers" => array("Content-Type" => "application/json"),
                "status" => 200
        );

        // Arrange
        $this->svc
                ->Given("there is a role called developer and no developers named daniele")
                ->UponReceiving("post new developer")
                ->With($request)
                ->WillRespond($expectedResponse);

        // Act
        $actualResponse = $this->svc->Start();

        // Assert
        $actualResponseBody = json_decode((string)$actualResponse->getBody(), true);
        $this->assertEquals($expectedResponse['body'], $actualResponseBody);
        $this->assertEquals($expectedResponse['status'], 200);
    }

    public function testGetUnknownCollaboratorReturnsNotFoundError()
    {

        $request = array(
                "headers" => array("Accept" => "application/json"),
                "method" => "GET",
                "path" => "/collaborators/111"
        );

        $expectedResponse = array(
                "headers" => array("Content-Type" => "application/json"),
                "status" => 404,
                "body" => array("error" => "Not Found")
        );

        // Arrange
        $this->svc
                ->Given("there is not any collaborator with identifier 111")
                ->UponReceiving("get collaborator")
                ->With($request)
                ->WillRespond($expectedResponse);

        // Act
        $this->svc->Start();

        // Assert
        $this->assertEquals($expectedResponse['status'], 404);
    }

    public function testDeleteCollaboratorByID()
    {

        $request = array(
                "headers" => array("Accept" => "application/json"),
                "method" => "DELETE",
                "path" => "/collaborators/111"
        );

        $expectedResponse = array(
                "headers" => array("Content-Type" => "application/json"),
                "status" => 200,
                "body" => array()
        );

        // Arrange
        $this->svc
                ->Given("there is a collaborator with identifier 111")
                ->UponReceiving("delete collaborator")
                ->With($request)
                ->WillRespond($expectedResponse);

        // Act
        $this->svc->Start();

        // Assert
        $this->assertEquals($expectedResponse['status'], 200);
    }
}

