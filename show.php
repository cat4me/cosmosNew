<?php

require_once 'databaseConnect.php';

class Show
{
    public function show()
    {
        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = file_get_contents(__DIR__ . '/sql/SelectObjects.sql');
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
