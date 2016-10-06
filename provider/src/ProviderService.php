<?php


use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Response;

class ProviderService
{

    public function get($id)
    {
        $collab = CollaboratorDataResource::getCollaborator($id);
        if ($collab === null) {
            return $this->notFound();
        }

        $response = Response::create(
                json_encode($collab),
                Response::HTTP_OK,
                array("Content-Type" => "application/json")
        );

        $psr7Factory = new DiactorosFactory();
        return $psr7Factory->createResponse($response);
    }

    public function post()
    {
        $newCollaborator = json_decode($_POST['body'], true);
        $newCollaboratorJson = CollaboratorDataResource::addCollaborator($newCollaborator);

        $response = Response::create(
                json_encode($newCollaboratorJson),
                Response::HTTP_OK,
                array("Content-Type" => "application/json")
        );

        $psr7Factory = new DiactorosFactory();
        return $psr7Factory->createResponse($response);
    }

    public function delete($id)
    {
        CollaboratorDataResource::removeCollaborator($id);

        $response = Response::create(
                json_encode(array()),
                Response::HTTP_OK,
                array("Content-Type" => "application/json")
        );

        $psr7Factory = new DiactorosFactory();
        return $psr7Factory->createResponse($response);
    }


    public function notFound()
    {
        $response = Response::create(
                json_encode(array("error" => "Not Found")),
                Response::HTTP_NOT_FOUND,
                array("Content-Type" => "application/json")
        );

        $psr7Factory = new DiactorosFactory();
        return $psr7Factory->createResponse($response);
    }

}
