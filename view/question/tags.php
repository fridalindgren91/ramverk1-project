<?php

namespace Anax\View;

$tags = isset($tags) ? $tags : null;

$urlToView = url("question/tags");

?><h1>Taggar</h1>

<?php if (!$tags) : ?>
    <p>Det finns för närvarande inga taggar.</p>
<?php
    return;
endif;
?>

    <?php foreach ($tags as $tag) :
            for($i = 0; $i < count($tag); $i++) {
                echo "<div class='tagDiv'><a href='" . url("question/tag/{$tag[$i]}") . "'>" . $tag[$i] . "</a></div><br><br>";
            }
    endforeach; ?>
