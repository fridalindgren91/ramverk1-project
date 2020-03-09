<?php

namespace Frida\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Frida\Profile\Profile;
use Frida\User\User;
use Frida\Question\Answer;
use Frida\Question\Question;
use \Michelf\Markdown;

class AnswerForm extends FormModel
{
    public function __construct(ContainerInterface $di, $questionID)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Svar",
            ],
            [
                "questionID" => [
                    "type" => "hidden",
                    "value" => $questionID,
                ],
                "answer" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "label" => "",
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
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answerValue = $this->textfilter($this->form->value("answer"));
        $answer->answer = $answerValue;
        $answer->questionID = $this->form->value("questionID");
        $answer->author = $this->di->session->get("username");
        $answer->created = date("Y-m-d h:i:s");
        $answer->save();
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
