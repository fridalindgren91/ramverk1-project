<?php

namespace Frida\Profile;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Frida\Profile\HTMLForm\UpdateForm;
use Frida\Profile\Profile;
use Frida\Question\Question;
use Frida\Question\Answer;

class ProfileController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $profile = new Profile();
        $profile->setDb($this->di->get("dbqb"));
        $loggedinUser = $this->di->session->get("username");
        $user = $profile->find("username", $loggedinUser);
        $gravatar = $this->getGravatar($user->email);
        
        $page->add("profile/profile", [
            "details" => $user,
            "gravatar" => $gravatar,
        ]);

        return $page->render([
        ]);
    }

    public function updateAction() : object
    {
        $page = $this->di->get("page");
        $profile = new Profile();
        $profile->setDb($this->di->get("dbqb"));
        $loggedinUser = $this->di->session->get("username");
        $form = new UpdateForm($this->di, $loggedinUser);
        $form->check();

        $page->add("profile/update", [
             "form" => $form->getHTML(),
        ]);

        return $page->render([
            "details" => $profile->findAll(),
        ]);
    }

    public function visitProfileAction($author) : object
    {
        $page = $this->di->get("page");
        $profile = new Profile();
        $profile->setDb($this->di->get("dbqb"));
        $userProfile = $profile->find("username", $author);
        $gravatar = $this->getGravatar($userProfile->email);
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAllWhere("author = ?", [$author]);
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("author = ?", [$author]);
        $questionsFromAnswersArr = [];
        foreach ($answers as $a) {
            $questionsFromAnswers = new Question();
            $questionsFromAnswers->setDb($this->di->get("dbqb"));
            array_push($questionsFromAnswersArr, $questionsFromAnswers->find("id", $a->questionID));
        }
        
        $page->add("profile/visitProfile", [
            "profile" => $userProfile,
            "questions" => $questions,
            "answers" => $answers,
            "questionsFromAnswers" => $questionsFromAnswersArr,
            "gravatar" => $gravatar,
        ]);

        return $page->render([
        ]);
    }

    public function getGravatar($email)
    {
        $default = "https://publicdomainvectors.org/photos/DogProfile.png";
        $size = 400;
        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
        return $grav_url;
    }
}
