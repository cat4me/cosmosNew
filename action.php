<?php

require_once 'function.php';
require_once 'add.php';
require_once 'show.php';
require_once 'delete.php';
require_once 'update.php';

//выбрать действие и вызвать нужную функцию
switch ($_REQUEST['act'])
{
    case 'delete':
        extract(checkAndPrepareParams($_REQUEST, ['id']));
        $delete = new Delete();
        $delete->delete((int)$id);
        break;
    case 'update':
        extract(checkAndPrepareParams($_REQUEST, ['id'], ['parentId', 'name', 'type']));
        $update = new Update();
        $update->update((int)$id, $parentId, $name, $type);
        break;
    case 'add':
        extract(checkAndPrepareParams($_REQUEST, ['name'], ['parentId', 'type']));
        $add = new Add();
        $add->add($parentId, $name, $type);
        break;
    case 'show':
        $show = new Show();
        $show->show();
        break;
    default:
        echo 'Не существует данной функции';
        break;
}

//ловить ошибки
register_shutdown_function(function (){
    var_dump(error_get_last());
    die;
});