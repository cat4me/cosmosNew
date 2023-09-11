<?php

require_once 'function.php';
require_once 'databaseConnect.php';

class Delete
{
    public function delete($id)
    {
        $this->prepareDelete($id);
        $query = new DB();
        $query->beginTransaction();
        try {
            # рекурсивное выделение id ВСЕХ потомков
            $sql = file_get_contents(__DIR__ . '/sql/RecursiveDelete.sql');
            $params = [[$id, 'int']];
            $query->query($sql, $params);
            $query->commit();
            $arr = $query->query($sql, $params);
            # удаление id потомков, которые были сохранены в arr
            foreach ($arr as $value) {
                $query->beginTransaction();
                $params = [[$value['id'], 'string']];
                $sql = file_get_contents(__DIR__ . '/sql/delete.sql');
                $query->query($sql, $params);
                $query->commit();
            }


        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }
    }

    private function prepareDelete($id)
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
        }
    }
}
