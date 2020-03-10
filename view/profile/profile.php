<?php

namespace Anax\View;

$details = isset($details) ? $details : null;

$urlToView = url("profile/update");



?><h1>Användarprofil</h1>
<img src="<?= $gravatar ?>" alt="avatar dog" class="avatar"><br>
<b>Användarnamn:</b> <?= $details->username ?><br><br>
<b>Beskrivning:</b><br>
<?= $details->description ?><br><br>
<a href="<?= $urlToView ?>">Uppdatera profil</a>
