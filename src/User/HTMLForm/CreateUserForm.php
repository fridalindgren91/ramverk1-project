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

                "email" => [
                    "type"        => "email",
                    "label" => "Email",
                    "placeholder" => "Email",
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
        if ($this->form->value("username") == "" || $this->form->value("username") == null) {
            $this->form->addOutput("<div class='warningDiv'>Du måste fylla i ett användarnamn!</div>");
            return false;
        } else {
            $checkIfUsernameExist = $user->find("username", $this->form->value("username"));
            if (isset($checkIfUsernameExist)) {
                $this->form->addOutput("<div class='warningDiv'>Användarnamnet är upptaget!</div>");
                return false;
            } else {
                $user->username = $this->form->value("username");
            }
        }
        if ($this->form->value("email") == "" || $this->form->value("email") == null) {
            $this->form->addOutput("<div class='warningDiv'>Du måste fylla i en epostadress!</div>");
            return false;
        } else {
            $user->email = $this->form->value("email");
        }
        if ($this->form->value("password") == "" || $this->form->value("password") == null) {
            $this->form->addOutput("<div class='warningDiv'>Du måste fylla i ett lösenord!</div>");
            return false;
        } else {
            $user->setPassword($this->form->value("password"));
        }
        $user->save();
        return true;
    }

    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/login")->send();
    }
}
