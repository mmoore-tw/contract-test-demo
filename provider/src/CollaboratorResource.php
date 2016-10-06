<?php

class CollaboratorDataResource
{
    public static $collaborators = array();

    public static function getCollaborator($id)
    {
        foreach (self::$collaborators as $collaborator) {
            if ($collaborator['id'] == $id) {
                return $collaborator;
            }
        }

        return null;
    }

    public static function addCollaborator(array $newCollaborator)
    {

        $temp = $newCollaborator;

        // add new ID and add to collection
        $temp['id'] = sprintf("%0d", rand(50, 1000));
        array_push(self::$collaborators, $temp);
        return $temp;
    }

    public static function removeCollaborator($id)
    {
        foreach (self::$collaborators as $collaborator) {
            if ($collaborator['id'] == $id) {
                unset($collaborator);
                break;
            }
        }
    }

    public static function cleanAll()
    {
        self::$collaborators = array();
    }

}
