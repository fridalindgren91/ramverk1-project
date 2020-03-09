<?php

namespace Anax\View;

$question = isset($question) ? $question : null;

?><h1>Kommentera en fråga</h1>

        <h3><?= $question->title ?></h3>
        Skapad: <i><?= $question->created ?></i> av 
        <a href="<?= url("profile/visitProfile/{$question->author}"); ?>"><?= $question->author ?></a>
        <div class="questionDiv"><?= $question->question ?></div><br>
        <?= $cForm ?>

