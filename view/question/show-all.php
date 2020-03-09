<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
$answers = isset($answers) ? $answers : null;
$comments = isset($comments) ? $comments : null;

$urlToView = url("question/create");

?><h1>Diskussion</h1>

<a href="<?= $urlToView ?>">Skapa en fråga</a>

<?php if (!$questions) : ?>
    <p>Det finns för närvarande inga diskussioner.</p>
<?php
    return;
endif;
?>

    <?php foreach ($questions as $question) : ?>
        <div class="clear"></div>
        <h3><?= $question->title ?></h3>
        Skapad: <i><?= $question->created ?></i> av 
        <a href="<?= url("profile/visitProfile/{$question->author}"); ?>"><?= $question->author ?></a>
        <div class="questionDiv"><?= $question->question ?></div><br>
        <a href="<?= url("question/answer/{$question->id}"); ?>">Svara</a><br>
        <a href="<?= url("question/commentQuestion/{$question->id}"); ?>">Kommentera</a><br><br>
        <?php 
            $tags = explode(",", $question->tags);
            if (array_filter($tags)) {
                for($i = 0; $i < count($tags); $i++) {
                    echo "<div class='tagDiv'><a href='" . url("question/tag/{$tags[$i]}") . "'>" . $tags[$i] . "</a></div>";
                }
            }
            foreach ($comments as $comment) :
                if ($question->id == $comment->questionID) {
                    echo '<div class="commentDiv"><p class="commentHeader">Kommentar</p><a href="' . url("profile/visitProfile/{$comment->author}") . '">' . $comment->author . '</a><br><i>' . $comment->created . '</i><br><br>' . $comment->comment . '</div><br>';
                    echo "<div class='clear'></div>";
                }
            endforeach;
            foreach ($answers as $answer) :
                if ($question->id == $answer->questionID) {
                    echo "<div class='clear'></div>";
                    echo '<div class="answerDiv"><p class="answerHeader">Svar</p><a href="' . url("profile/visitProfile/{$answer->author}") . '">' . $answer->author . '</a><br><i>' . $answer->created . '</i><br><br>' . $answer->answer . '<br><br><a href="' . url("question/commentAnswer/{$answer->id}") . '">Kommentera</a></div><br>';
                    foreach ($comments as $comment) :
                        if ($answer->id == $comment->answerID) {
                            echo '<div class="commentAnswerDiv"><p class="commentHeader">Kommentar</p><a href="' . url("profile/visitProfile/{$comment->author}") . '">' . $comment->author . '</a><br><i>' . $comment->created . '</i><br><br>' . $comment->comment . '</div><br>';
                            echo "<div class='clear'></div>";
                        }
                    endforeach;
                }
            endforeach;
        endforeach; ?>
