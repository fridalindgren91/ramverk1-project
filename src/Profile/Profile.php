<?php

namespace Frida\Profile;

use Anax\DatabaseActiveRecord\ActiveRecordModel;


/**
 * A database driven model using the Active Record design pattern.
 */
class Profile extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "user";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $username;
    public $password;
    public $description;
}
