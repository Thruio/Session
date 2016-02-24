<?php
namespace Thru\Session;

use Monolog\Logger;
use Slim\Log;
use \Thru\ActiveRecord\ActiveRecord;

/**
 * Class SessionModel
 * @package Tenderbid\Models
 * @var $session_id INTEGER
 * @var $php_id INTEGER
 * @var $data TEXT
 * @var $click INTEGER
 * @var $created DATETIME
 * @var $updated DATETIME
 * @var $deleted ENUM("Yes","No")
 */
class SessionModel extends ActiveRecord
{
    protected $_table = "sessions";

    public $session_id;
    public $php_id;
    public $data;
    public $click = 0;
    public $created;
    public $updated;
    public $deleted = "No";

    public function save($automatic_reload = true)
    {
        if (!$this->created) {
            $this->created = date("Y-m-d H:i:s");
        }
        $this->updated = date("Y-m-d H:i:s");
        $this->click++;
        parent::save($automatic_reload);
    }

    public function delete()
    {
        $this->deleted = "Yes";
        $this->save();
    }
}
