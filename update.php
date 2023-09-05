<?php

class Update
{
    public function update($id, $parentId, $name, $type)
    {
        $this->prepareUpdate($id, $parentId, $name, $type);
        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = file_get_contents(__DIR__ . '/sql/update.sql');
            $params = [[$parentId, 'int'], [$name, 'string'], [$type, 'string'], [$id, 'int']];
            $query->query($sql, $params);
            $query->commit();
        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }
    }

    private function prepareUpdate($id, &$parentId, &$name, &$type)
    {
        if ($id == 'null') {
            echo "id объекта не определен";
            die;
        }

        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = file_get_contents(__DIR__ . '/sql/SelectObjectsWhereid.sql');
            $params = [[$id, 'int']];
            $query->query($sql, $params);
            $query->commit();
        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }

        if (empty($query->query($sql, $params))) {
            echo "объекта с таким id не существует";
            die;
        }

        $arr = $query->query($sql, $params);
        var_dump($arr);
        if ($parentId == null) {
            $parentId = $arr[0]['parent_id'];
        }

        if ($name == null) {
            $name = $arr[0]['name'];
        }

        if ($type == null) {
            $type = $arr[0]['type'];
        }
    }
}

