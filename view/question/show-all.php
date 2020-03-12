<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
$answers = isset($answers) ? $answers : null;
$comments = isset($comments) ? $comments : null;
$loggedInUser = $this->di->session->get("username");

$urlToView = url("question/create");
$default = "https://publicdomainvectors.org/photos/DogProfile.png";
$size = 400;

?><h1>Diskussion</h1>
<?php
    if (isset($loggedInUser)) {
        echo '<a href="' . $urlToView . '">Skapa en fråga</a>';
    }

    if (!$questions) : ?>
        <p>Det finns för närvarande inga diskussioner.</p>
<?php
    return;
endif;
?>

    <?php foreach ($questions as $question) : ?>
        <div class="clear"></div><br>
        <?php foreach ($users as $user) {
            if (strtolower($question->author) == strtolower($user->username)) { ?>
                <div class="avatar-side">
                    <?php $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size; ?>
                    <img src="<?= $grav_url ?>" alt="avatar dog" class="avatar rounded-corners">
                </div>
            <?php
            }
        } ?>
        
        <div class="question-side">
            <h3><?= $question->title ?></h3>
            Skapad: <i><?= $question->created ?></i> av 
            <a href="<?= url("profile/visitProfile/{$question->author}"); ?>"><?= $question->author ?></a>
            <div class="questionDiv"><?= $question->question ?></div><br>
            <div class="clear"></div>
            <?php if (isset($loggedInUser)) {
                echo '<a href="' . url("question/answer/{$question->id}") . '">Svara</a><br>';
                echo '<a href="' . url("question/commentQuestion/{$question->id}") . '">Kommentera</a><br><br>';
            }
                $tags = explode(",", strtolower($question->tags));
                if (array_filter($tags)) {
                    for($i = 0; $i < count($tags); $i++) {
                        echo "<div class='tagDiv'><a href='" . url("question/tag/{$tags[$i]}") . "'>" . $tags[$i] . "</a></div>";
                    }
                }
            echo "</div>";
            foreach ($comments as $comment) :
                if ($question->id == $comment->questionID) {
                    echo "<div class='clear'></div>";
                    echo '<div class="commentDiv"><p class="commentHeader">Kommentar</p>';
                    foreach ($users as $user) {
                        if (strtolower($comment->author) == strtolower($user->username)) { ?>
                            <div class="avatar-side">
                                <?php $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size; ?>
                                <img src="<?= $grav_url ?>" alt="avatar dog" class="avatar rounded-corners comment-avatar">
                            </div>
                        <?php
                        }
                    }
                    echo '<div class="question-side">';
                    echo '<a href="' . url("profile/visitProfile/{$comment->author}") . '">' . $comment->author . '</a><br>';
                    echo '<i>' . $comment->created . '</i><br><br>' . $comment->comment . '</div><br>';
                    echo "</div>";
                    echo "<div class='clear'></div>";
                }
            endforeach;
            foreach ($answers as $answer) :
                if ($question->id == $answer->questionID) {
                    echo "<div class='clear'></div>";
                    echo '<div class="answerDiv"><p class="answerHeader">Svar</p>';
                    foreach ($users as $user) {
                        if (strtolower($answer->author) == strtolower($user->username)) { ?>
                            <div class="avatar-side">
                                <?php $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size; ?>
                                <img src="<?= $grav_url ?>" alt="avatar dog" class="avatar rounded-corners">
                            </div>
                        <?php
                        }
                    }
                    echo '<div class="question-side">';
                    echo '<a href="' . url("profile/visitProfile/{$answer->author}") . '">' . $answer->author . '</a><br>';
                    echo '<i>' . $answer->created . '</i><br><br>' . $answer->answer . '<br><br>';
                    echo '<a href="' . url("question/commentAnswer/{$answer->id}") . '">Kommentera</a></div><br>';
                    echo "</div><br>";
                    foreach ($comments as $comment) :
                        if ($answer->id == $comment->answerID) {
                            echo "<div class='clear'></div>";
                            echo '<div class="commentAnswerDiv"><p class="commentHeader">Kommentar</p>';
                            foreach ($users as $user) {
                                if (strtolower($comment->author) == strtolower($user->username)) { ?>
                                    <div class="avatar-side">
                                        <?php $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size; ?>
                                        <img src="<?= $grav_url ?>" alt="avatar dog" class="avatar rounded-corners comment-avatar">
                                    </div>
                                <?php
                                }
                            }
                            echo '<div class="question-side">';
                            echo '<a href="' . url("profile/visitProfile/{$comment->author}") . '">' . $comment->author . '</a><br>';
                            echo '<i>' . $comment->created . '</i><br><br>' . $comment->comment . '</div><br>';
                            echo "</div>";
                            echo "<div class='clear'></div>";
                        }
                    endforeach;
                    
                }
            endforeach;
        endforeach; ?>
