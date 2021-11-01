<?php

namespace App\Models;

use Exception;

class User
{
    private static $table = 'user';

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public static function getUser(int $id): array
    {
        $conn = new \PDO(DBDRIVE. ':host='.DBHOST.';dbname='. DBNAME, DBUSER    , DBPASS);
        $sql = "SELECT * FROM " . self::$table. " WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } else {
            throw new Exception('Nenhum usuario retornado');
        }
    }
}