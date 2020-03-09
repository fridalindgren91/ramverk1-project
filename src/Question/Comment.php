<?php

namespace Frida\Question;

use Anax\DatabaseActiveRecord\ActiveRecordModel;


/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "comments";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $author;
    public $comment;
    public $questionID;
    public $answerID;
    public $created;
}
