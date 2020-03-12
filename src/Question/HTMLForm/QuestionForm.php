<?php

namespace Frida\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Frida\Profile\Profile;
use Frida\User\User;
use Frida\Question\Question;
use \Michelf\Markdown;

class QuestionForm extends FormModel
{
    public function __construct(ContainerInterface $di, $username)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Fråga",
            ],
            [
                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "label" => "Rubrik",
                ],
                "question" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "label" => "Fråga",
                ],
                "tags" => [
                    "type"        => "text",
                    "label"       => "Skriv taggar separerad med ett kommatecken",
                ],
                "Skicka" => [
                    "type" => "submit",
                    "value" => "Skicka",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }

    public function callbackSubmit()
    {
        if ($this->form->value("tags") == null || $this->form->value("tags") == "") {
            $this->form->addOutput("<div class='warningDiv'>Du måste fylla i taggar!</div>");
            return false;
        }
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title = $this->form->value("title");
        $questionValue = $this->textfilter($this->form->value("question"));
        $question->question = $questionValue;
        $question->author = $this->di->session->get("username");
        $question->created = date("Y-m-d h:i:s");
        $question->tags = strtolower($this->form->value("tags"));
        $question->save();
        return true;
    }

    public function textfilter($text)
    {
        return Markdown::defaultTransform($text);
    }

    public function callbackFail()
    {
        $this->di->get("response")->redirectSelf()->send();
    }

    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("question")->send();
    }
}
