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
            $sql = "WITH RECURSIVE descendants AS
                    (
                    SELECT id
                    FROM objects
                    WHERE id = ?
                    UNION ALL
                    SELECT t.id
                    FROM descendants d, objects t
                    WHERE t.parent_id=d.id
                    )
                    SELECT * FROM descendants;";
            $params = [[$id, 'int']];
            $query->query($sql, $params);
            $query->commit();
            $arr = $query->query($sql, $params);
            foreach ($arr as $value) {
                $query->beginTransaction();
                $params = [[$value['id'], 'string']];
                $sql = "DELETE FROM objects WHERE id = ?";
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
            $sql = "SELECT * FROM objects WHERE id = ?";
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
