<?php
/**
 * Supply the basis for the navbar as an array.
 */

if (isset($_SESSION["username"])) {
    return [
        // Use for styling the menu
        "wrapper" => null,
        "class" => "my-navbar rm-default rm-desktop",
     
        // Here comes the menu items
        "items" => [
            [
                "text" => "Hem",
                "url" => "",
                "title" => "Hem",
            ],
            [
                "text" => "Om",
                "url" => "om",
                "title" => "Om denna webbplats.",
            ],
            [
                "text" => "Diskussion",
                "url" => "question",
                "title" => "Diskussionsforum",
            ],
            [
                "text" => "Taggar",
                "url" => "question/tags",
                "title" => "Taggar",
            ],
            [
                "text" => "Profil",
                "url" => "profile",
                "title" => "Profil",
            ],
            [
                "text" => "Logga ut",
                "url" => "user/logout",
                "title" => "Logga ut",
            ],
        ],
    ];
} else {
    return [
        // Use for styling the menu
        "wrapper" => null,
        "class" => "my-navbar rm-default rm-desktop",
     
        // Here comes the menu items
        "items" => [
            [
                "text" => "Hem",
                "url" => "",
                "title" => "Hem",
            ],
            [
                "text" => "Om",
                "url" => "om",
                "title" => "Om denna webbplats.",
            ],
            [
                "text" => "Diskussion",
                "url" => "question",
                "title" => "Diskussionsforum",
            ],
            [
                "text" => "Taggar",
                "url" => "question/tags",
                "title" => "Taggar",
            ],
            [
                "text" => "Logga in",
                "url" => "user/login",
                "title" => "Logga in",
            ],
        ],
    ];
}
