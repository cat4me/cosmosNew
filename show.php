<?php

require_once 'databaseConnect.php';

class Show
{
    public function show()
    {
        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = "SELECT * FROM objects";
            $params = [];
            $query->query($sql, $params);
            $query->commit();
            print_r($query->query($sql, $params));
        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }
    }
}
