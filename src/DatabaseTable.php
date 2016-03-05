<?php
namespace Itb;

class DatabaseTable
{

    public static function getClass()
    {
        return __CLASS__;
    }

    public static function getAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = 'SELECT * from ' . join('', array_slice(explode('\\', static::getClass()), -1));

        $statement = $connection->prepare($sql);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\' .  __CLASS__);
        $statement->execute();

        $objects = $statement->fetchAll();
        return $objects;
    }

    public static function getOneById($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $statement = $connection->prepare('SELECT * from ' .  join('', array_slice(explode('\\', static::getClass()), -1)) . ' WHERE id=:id');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\' .  __CLASS__);
        $statement->execute();

        if ($object = $statement->fetch()) {
            return $object;
        } else {
            return null;
        }
    }


    /**
     * delete record for given ID - return true/false depending on delete success
     * @param $id
     *
     * @return bool
     */

    public static function delete($id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $statement = $connection->prepare('DELETE from ' . join('', array_slice(explode('\\', static::getClass()), -1)) . ' WHERE id=:id');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $queryWasSuccessful = $statement->execute();
        return $queryWasSuccessful;
    }


    public static function searchByColumn($columnName, $searchText)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        // wrap wildcard '%' around the serach text for the SQL query
        $searchText = '%' . $searchText . '%';

        $statement = $connection->prepare('SELECT * from ' . join('', array_slice(explode('\\', static::getClass()), -1)) . ' WHERE ' . $columnName . ' LIKE :searchText');
        $statement->bindParam(':searchText', $searchText, \PDO::PARAM_STR);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\' .  static::getClass());
        $statement->execute();

        $objects = $statement->fetchAll();

        return $objects;
    }


    /**
     * insert new record into the DB table
     * returns new record ID if insertation was successful, otherwise -1
     * @param Object $object
     * @return integer
     */
    public static function create($object)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $objectAsArrayForSqlInsert = DatatbaseUtility::objectToArrayLessId($object);
        $fields = array_keys($objectAsArrayForSqlInsert);
        $insertFieldList = DatatbaseUtility::fieldListToInsertString($fields);
        $valuesFieldList = DatatbaseUtility::fieldListToValuesString($fields);

        $statement = $connection->prepare('INSERT into '. join('', array_slice(explode('\\', static::getClass()), -1)) . ' ' . $insertFieldList . $valuesFieldList);
        $statement->execute($objectAsArrayForSqlInsert);

        $queryWasSuccessful = ($statement->rowCount() > 0);
        if ($queryWasSuccessful) {
            return $connection->lastInsertId();
        } else {
            return -1;
        }
    }


    /**
     * insert new record into the DB table
     * returns new record ID if insertation was successful, otherwise -1
     * @param Object $object
     * @return integer
     */
    public static function update($object, $id)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $objectAsArrayForSqlInsert = DatatbaseUtility::objectToArrayLessId($object);
        $fields = array_keys($objectAsArrayForSqlInsert);
        $updateFieldList = DatatbaseUtility::fieldListToUpdateString($fields);

        $sql = 'UPDATE '. join('', array_slice(explode('\\', static::getClass()), -1)) . ' SET ' . $updateFieldList  . ' WHERE id=:id';
        $statement = $connection->prepare($sql);

        // add 'id' to parameters array
        $objectAsArrayForSqlInsert['id'] = $id;

        $queryWasSuccessful = $statement->execute($objectAsArrayForSqlInsert);

        return $queryWasSuccessful;
    }
}
