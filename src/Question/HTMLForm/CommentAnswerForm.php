<?php

namespace Frida\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Frida\Profile\Profile;
use Frida\User\User;
use Frida\Question\Answer;
use Frida\Question\Question;
use Frida\Question\Comment;
use \Michelf\Markdown;

class CommentAnswerForm extends FormModel
{
    public function __construct(ContainerInterface $di, $answerID)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Kommentar",
            ],
            [
                "answerID" => [
                    "type" => "hidden",
                    "value" => $answerID,
                ],
                "comment" => [
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
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $commentValue = $this->textfilter($this->form->value("comment"));
        $comment->comment = $commentValue;
        $comment->answerID = $this->form->value("answerID");
        $comment->author = $this->di->session->get("username");
        $comment->created = date("Y-m-d h:i:s");
        $comment->save();
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
