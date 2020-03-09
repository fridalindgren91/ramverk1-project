<?php

namespace Frida\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Frida\User\User;

class CreateUserForm extends FormModel
{
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Registrera",
            ],
            [
                "username" => [
                    "type"        => "text",
                    "label" => "Användarnamn",
                    "placeholder" => "Användarnamn",
                ],
                        
                "password" => [
                    "type"        => "password",
                    "label" => "Lösenord",
                    "placeholder" => "Lösenord",
                ],

                "Registrera" => [
                    "type" => "submit",
                    "value" => "Registrera",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }

    public function callbackSubmit()
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $user->username = $this->form->value("username");
        $user->setPassword($this->form->value("password"));
        $user->save();
        return true;
    }

    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("profile")->send();
    }
}
