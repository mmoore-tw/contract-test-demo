<?php

//require_once "../src/CollaboratorResource.php";
//require_once "../src/ProviderService.php";

use Pact\Phpacto\Test\PactoIntegrationTest;
use Pact\Phpacto\Test\PactoIntegrationTestInterface;
use Psr\Http\Message\RequestInterface;


class ProviderTest extends PHPUnit_Framework_TestCase implements PactoIntegrationTestInterface
{

    private $pacto;

    protected function setUp()
    {
        // read all the contracts located in folder
        $this->createPactoInstance();
        $this->pacto->loadContracts(CONTRACT_INPUT);
//        $this->pacto->loadContracts("../../contracts");
    }

    public function createPactoInstance()
    {
        $this->pacto = new PactoIntegrationTest('Provider');
    }


    public function testHonorContracts()
    {

        $this->pacto->honorContracts(
                function (RequestInterface $req) {

                    $app = new ProviderService();
                    $coreResponse = null;

                    switch ($req->getMethod()) {
                        case "GET":
                            $id = explode('/', $req->getUri()->getPath())[2];
                            $coreResponse = $app->get($id);
                            break;
                        case "POST":
                            $coreResponse = $app->post();
                            break;
                        case "DELETE":
                            $coreResponse = $app->delete("111");
                            break;
                    }

                    return $coreResponse;

                },
                function ($state) {

                    // setup the provider state with the desired object
                    switch ($state) {
                        case "there is a collaborator with id 23":
                            array_push(
                                    CollaboratorDataResource::$collaborators,
                                    array("name" => "John", "role" => "Client Relantionship", "id" => "23")
                            );
                            break;
                        case "there is a role called developer and no developers named daniele":
                            $_POST['body'] = json_encode(array("username" => "daniele", "role" => "developer"));
                            break;
                        case "there is not any collaborator with identifier 111":
                            break;
                        case "there is a collaborator with identifier 111":
                            array_push(
                                    CollaboratorDataResource::$collaborators,
                                    array("name" => "John", "role" => "Client Relantionship", "id" => "111")
                            );
                            break;
                    }
                },
                function () {
                    // clean up
                    CollaboratorDataResource::cleanAll();
                    unset($_POST['body']);
                }
        );
    }

}
