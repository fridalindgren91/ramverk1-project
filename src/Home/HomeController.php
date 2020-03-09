<?php

namespace Frida\Home;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Frida\Question\HTMLForm\QuestionForm;
use Frida\Question\Question;
use Frida\Profile\Profile;
use Frida\Question\Answer;
use Frida\Question\Comment;
use Frida\Question\HTMLForm\AnswerForm;
use Frida\Question\HTMLForm\CommentQuestionForm;
use Frida\Question\HTMLForm\CommentAnswerForm;

class HomeController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $allQuestions = $question->findAll();
        $questionTags = $question->findAllWhere("? IS NOT NULL", ["tags"]);
        $tagArray = [];
        foreach ($questionTags as $q) {
            $tags = $q->tags;
            $explodedTags = explode(",", $tags);
            for ($i = 0; $i < count($explodedTags); $i++) {
                array_push($tagArray, $explodedTags[$i]);
            }
        }
        $countedTags = array_count_values($tagArray);
        arsort($countedTags);
        $tagSlicedByFive = array_slice(array_keys($countedTags), 0, 5, true);

        $answers = new Answer();
        $answers->setDb($this->di->get("dbqb"));
        $allAnswers = $answers->findAll();
        $authorArray = [];
        foreach ($allAnswers as $a) {
            array_push($authorArray, $a->author);
        }

        $comments = new Comment();
        $comments->setDb($this->di->get("dbqb"));
        $allComments = $comments->findAll();
        foreach ($allComments as $c) {
            array_push($authorArray, $c->author);
        }

        $countedAuthorArray = array_count_values($authorArray);
        arsort($countedAuthorArray);
        $authorSlicedByFive = array_slice(array_keys($countedAuthorArray), 0, 5, true);

        $page->add("home/home", [
            "questions" => array_reverse($allQuestions),
            "tags" => $tagSlicedByFive,
            "authors" => $authorSlicedByFive,
        ]);

        return $page->render([
        ]);
    }
}
