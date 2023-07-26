<?php

require_once 'function.php';
require_once 'databaseConnect.php';
class Add
{
    public function add($parentId, $name, $type)
    {
        $this->prepareAdd($parentId, $name, $type);
        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = "INSERT INTO objects (parent_id, name, type) VALUES (?, ?, ?)";
            var_dump($parentId, $name, $type);
            $params = [[$parentId, 'int'], [$name, 'string'], [$type, 'string']];
            $query->query($sql, $params);
            $query->commit();
        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }

    }

    private function prepareAdd(&$parentId, &$name, &$type)
    {
        if ($name == 'null') {
            echo "название объекта не передано";
            die;
        }

        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = "SELECT * FROM objects";
            $params = [];
            $query->query($sql, $params);
            $query->commit();
        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }

        $arr = $query->query($sql, $params);
        foreach ($arr as $value) {
            if ($parentId == $value['parent_id'] and $name == $value['name'] and $type == $value['type']) {
                echo "Такой объект уже существует";
                die;
            }
        }
    }
}