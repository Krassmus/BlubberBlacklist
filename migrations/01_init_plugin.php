<?php

class InitPlugin extends Migration
{
    public function up()
    {
        DBManager::get()->exec("
            INSERT INTO `roles`
            SET `rolename` = 'BlubberBlacklist',
            `system` = 'n'
        ");
        StudipCacheFactory::getCache()->flush();
    }

    public function down()
    {
        $statement = DBManager::get()->prepare("
            SELECT `roleid` FROM roles WHERE `rolename` = 'BlubberBlacklist'
        ");
        $statement->execute();
        $id = $statement->fetch(PDO::FETCH_COLUMN, 0);
        $statement = DBManager::get()->prepare("
            DELETE FROM `roles_user` WHERE `roleid` = :id
        ");
        $statement->execute([
            'id' => $id
        ]);
        $statement = DBManager::get()->prepare("
            DELETE FROM `roles_plugins` WHERE `roleid` = :id
        ");
        $statement->execute([
            'id' => $id
        ]);
        DBManager::get()->exec("
            DELETE FROM `roles`
            WHERE `rolename` = 'BlubberBlacklist'
        ");
        StudipCacheFactory::getCache()->flush();
    }
}
