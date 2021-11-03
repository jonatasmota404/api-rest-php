<?php

namespace App\Models;

use Exception;
use PDO;

class User
{
    private static string $table = 'user';
    private static ?PDO $conn;

    public static function connect()
    {
        self::$conn = new PDO(DBDRIVE. ':host='.DBHOST.';dbname='. DBNAME, DBUSER, DBPASS);
    }

    public static function destroy()
    {
        self::$conn = null;
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public static function getUser(int $id): array
    {

        $sql = "SELECT * FROM " . self::$table. " WHERE id = :id";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            throw new Exception(json_encode(['error'=>['message'=>'Nenhum usuario retornado', 'code' => 404]]));
        }
    }
}