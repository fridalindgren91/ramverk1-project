<?php

namespace Anax\View;

$answer = isset($answer) ? $answer : null;

?><h1>Kommentera ett svar</h1>

<div class="answerDiv">
        <i><?= $answer->created ?></i> av 
        <a href="<?= url("profile/visitProfile/{$answer->author}"); ?>"><?= $answer->author ?></a>
        <div class="questionDiv"><?= $answer->answer ?></div>
</div><br><br>
<?= $cForm ?>

