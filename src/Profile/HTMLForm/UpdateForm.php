<?php

namespace Frida\Profile\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Frida\Profile\Profile;
use Frida\User\User;

class UpdateForm extends FormModel
{
    public function __construct(ContainerInterface $di, $username)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($username);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Profil",
            ],
            [

                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->username,
                    "label" => "Användarnamn",
                ],

                "description" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "value" => $user->description,
                    "label" => "Beskrivning",
                ],

                "Spara" => [
                    "type" => "submit",
                    "value" => "Spara",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }

    public function getItemDetails($username) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("username", $username);
        return $user;
    }

    public function callbackSubmit()
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("username", $this->form->value("username"));
        $user->description = $this->form->value("description");
        $user->save();
        return true;
    }

    public function callbackFail()
    {
        $this->di->get("response")->redirectSelf()->send();
    }
}
