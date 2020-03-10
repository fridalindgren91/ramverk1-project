<?php

namespace Anax\View;

$profile = isset($profile) ? $profile : null;
$questions = isset($questions) ? $questions : null;
$answers = isset($answers) ? $answers : null;
$questionsFromAnswers = isset($questionsFromAnswers) ? $questionsFromAnswers : null;

?><h1>Användarprofil</h1>
<img src="<?= $gravatar ?>" alt="avatar dog" class="avatar"><br>

<b>Användarnamn:</b> <?= $profile->username ?><br><br>
<b>Beskrivning:</b><br>
<?= $profile->description ?><br><br>

<h3>Frågor som <?= $profile->username ?> har ställt</h3>
<?php
    if ($questions == null) {
        echo "Daniel har inte ställt några frågor ännu.";
    } else {
        foreach ($questions as $question) :
            echo "<h3>" . $question->title . "</h3>";
            echo "Skapad: <i>" . $question->created . "</i> av "; 
            echo "<a href=" . url('profile/visitProfile/{' . $question->author . '}') . ">" . $question->author . "</a>";
            echo "<div class='questionDiv'>" . $question->question . "</div><br>";
        endforeach;
    }
?>

<h3>Frågor som <?= $profile->username ?> har svarat på</h3>
<?php
    if ($questionsFromAnswers == null) {
        echo $profile->username . " har inte svarat på några frågor ännu.";
    } else {
        foreach ($questionsFromAnswers as $q) :
            echo "<h3>" . $q->title . "</h3>";
            echo "Skapad: <i>" . $q->created . "</i> av "; 
            echo "<a href=" . url('profile/visitProfile/{' . $q->author . '}') . ">" . $question->author . "</a>";
            echo "<div class='questionDiv'>" . $q->question . "</div><br>";
                foreach ($answers as $answer) :
                if ($q->id == $answer->questionID) {
                    echo '<div class="answerDiv"><a href="' . url("profile/visitProfile/{$answer->author}") . '">' . $answer->author . '</a><br><i>' . $answer->created . '</i><br><br>' . $answer->answer . '</div><br>';
                }
            endforeach;
        endforeach;
    }
?>

