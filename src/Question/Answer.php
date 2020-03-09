<?php

namespace Frida\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;


/**
 * A database driven model using the Active Record design pattern.
 */
class Answer extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "answers";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    // public $title;
    public $author;
    public $answer;
    public $questionID;
    public $created;
}
