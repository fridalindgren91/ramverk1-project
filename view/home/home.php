<?php

namespace Anax\View;

$questions = isset($questions) ? $questions : null;
$tags = isset($tags) ? $tags : null;
$authors = isset($authors) ? $authors : null;
$loggedInUser = $this->di->session->get("username");

?><h1>Välkommen</h1>
<h2>De fem senaste frågorna</h2>
<?php
if (!$questions) {
    echo "Det finns inga frågor ännu.";
}
    $questionCounter = 0;
    foreach ($questions as $question) : 
        if ($questionCounter >= 5) {
            break;
        }
    ?>
        <div class="clear"></div>
        <h3><?= $question->title ?></h3>
        Skapad: <i><?= $question->created ?></i> av 
        <a href="<?= url("profile/visitProfile/{$question->author}"); ?>"><?= $question->author ?></a>
        <div class="questionDiv"><?= $question->question ?></div><br>
        <?php if (isset($loggedInUser)) {
            echo '<a href="' . url("question/answer/{$question->id}") . '">Svara</a><br>';
            echo '<a href="' . url("question/commentQuestion/{$question->id}") . '">Kommentera</a><br><br>';
        }
        $questionCounter++;
    endforeach; ?>

<h2>De fem populäraste taggarna</h2>
<?php
    if (!$tags) {
        echo "Det finns inga taggar ännu.";
    }
    echo '<div class="clear"></div>';
    for($i = 0; $i < count($tags); $i++) {
        echo "<div class='tagDiv'><a href='" . url("question/tag/{$tags[$i]}") . "'>" . $tags[$i] . "</a></div>";
        echo '<div class="clear"></div>';
    }
?>

<h2>De fem aktivaste användarna</h2>
<?php
    if (!$authors) {
        echo "Det finns inga användare ännu.";
    }
    echo '<div class="clear"></div>';
    for($i = 0; $i < count($authors); $i++) {
        echo '<a href="' . url("profile/visitProfile/{$authors[$i]}") . '">' . $authors[$i] . '</a>';
    }
?>
