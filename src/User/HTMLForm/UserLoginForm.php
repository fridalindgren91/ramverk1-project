<?php

namespace Frida\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Frida\User\User;

class UserLoginForm extends FormModel
{
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Logga in"
            ],
            [
                "username" => [
                    "type"        => "text",
                    "label"      => "Användarnamn"
                ],
                        
                "password" => [
                    "type"        => "password",
                    "label"      => "Lösenord"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Logga in",
                    "callback" => [$this, "login"]
                ],
            ]
        );
        $this->form->addOutput(
            "Är du inte registrerad? <a href='./create'>Registrera dig</a>"
        );
    }

    public function login()
    {
        $username       = $this->form->value("username");
        $password      = $this->form->value("password");
    
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $res = $user->verifyPassword($username, $password);
    
        if (!$res) {
           $this->form->rememberValues();
           $this->form->addOutput("Användarnamn eller lösenord är felaktigt.");
           return false;
        }

        $this->di->session->set("username", $username);
        
        return true;
    }

    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("profile")->send();
    }
}
