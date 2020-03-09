<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
// $answers = isset($answers) ? $answers : null;
// $comments = isset($comments) ? $comments : null;

$urlToView = url("question/create");

?><h1><?= $tag ?></h1>

<!-- <a href="<?= $urlToView ?>">Skapa en fråga</a> -->

<?php if (!$questions) : ?>
    <p>Det finns för närvarande inga frågor i taggen <?= $tag ?>.</p>
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
        endforeach; ?>
