<?php

namespace Frida\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Frida\Question\HTMLForm\QuestionForm;
use Frida\Profile\Profile;
use Frida\Question\Answer;
use Frida\Question\Comment;
use Frida\Question\HTMLForm\AnswerForm;
use Frida\Question\HTMLForm\CommentQuestionForm;
use Frida\Question\HTMLForm\CommentAnswerForm;

class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $allQuestions = $question->findAll();
        $answers = new Answer();
        $answers->setDb($this->di->get("dbqb"));
        $allAnswers = $answers->findAll();
        $comments = new Comment();
        $comments->setDb($this->di->get("dbqb"));
        $allComments = $comments->findAll();
        
        $page->add("question/show-all", [
            "questions" => array_reverse($allQuestions),
            "answers" => $allAnswers,
            "comments" => $allComments,
        ]);

        return $page->render([
        ]);
    }

    public function createAction() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $loggedinUser = $this->di->session->get("username");
        $qForm = new QuestionForm($this->di, $loggedinUser);
        $qForm->check();

        $page->add("question/create", [
             "qForm" => $qForm->getHTML(),
        ]);

        return $page->render([
            "details" => $question->findAll(),
        ]);
    }

    public function answerAction($questionID) : object
    {
        $page = $this->di->get("page");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $loggedinUser = $this->di->session->get("username");
        
        $aForm = new AnswerForm($this->di, $questionID);
        $aForm->check();
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $page->add("question/answer", [
             "aForm" => $aForm->getHTML(),
             "question" => $question->find("id", $questionID),
        ]);

        return $page->render([
            
        ]);
    }

    public function commentQuestionAction($questionID) : object
    {
        $page = $this->di->get("page");
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $loggedinUser = $this->di->session->get("username");
        
        $cForm = new CommentQuestionForm($this->di, $questionID);
        $cForm->check();
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $page->add("question/commentQuestion", [
             "cForm" => $cForm->getHTML(),
             "question" => $question->find("id", $questionID),
        ]);

        return $page->render([
            
        ]);
    }

    public function commentAnswerAction($answerID) : object
    {
        $page = $this->di->get("page");
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $loggedinUser = $this->di->session->get("username");
        
        $cForm = new CommentAnswerForm($this->di, $answerID);
        $cForm->check();
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));

        $page->add("question/commentAnswer", [
             "cForm" => $cForm->getHTML(),
             "answer" => $answer->find("id", $answerID),
        ]);

        return $page->render([
            
        ]);
    }

    public function tagAction($tag) : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAllWhere("? IS NOT NULL", ["tags"]);
        $questionArray = [];
        foreach ($questions as $question) {
            $tagArray = explode(",", strtolower($question->tags));
            for ($i = 0; $i < count($tagArray); $i++) {
                if ($tagArray[$i] == $tag) {
                    array_push($questionArray, $question);
                }
            }
        }

        $page->add("question/tag", [
             "questions" => $questionArray,
             "tag" => $tag,
        ]);

        return $page->render([
            
        ]);
    }

    public function tagsAction() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAllWhere("? IS NOT NULL", ["tags"]);
        $tagObject = [];
        foreach ($questions as $question) {
            $tagArray = explode(",", strtolower($question->tags));
            array_push($tagObject, $tagArray);
        }

        $page->add("question/tags", [
             "tags" => $tagObject,
        ]);

        return $page->render([
            
        ]);
    }
}
