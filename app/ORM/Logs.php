<?php

namespace App\ORM;

use PDO;
use App\Entities\Logs as LogsEntity;

class Logs extends Model {
    protected $table = 'logs';

    public function addLog(LogsEntity $log){
        if($this->db->getConnection()->query("INSERT INTO {$this->table} (logs_event_type, logs_message, logs_timestamp) VALUES ('".$log->getEventType()."', '".$log->getMessage()."', '".$log->getTimestamp()->format('Y-m-d h:i:s')."')")){
            return true;
        }

        return false;
    }
}