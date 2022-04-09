<?php
class FamilyRecordCollection
{
    public static function getAll()
    {
        $query = "
        SELECT f.family_id,
               f.husband_id,
               f.wife_id,
               f.children_ids
        FROM   `families` AS f
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $results = $pdo->query($query)->fetchAll(PDO::FETCH_CLASS, 'FamilyRecord');
            return $results;
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }

        $pdo = null;
    }

    public static function get($family_id)
    {
        $query = "
        SELECT f.family_id,
               f.husband_id,
               f.wife_id,
               f.children_ids
        FROM   `families` AS f
        WHERE f.family_id = :family_id;
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam(':family_id', $family_id);

            $statement->execute();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
        $pdo = null;

        $statement->setFetchMode(PDO::FETCH_CLASS, "FamilyRecord");
        $record = $statement->fetch();
        $peopleRecords = PeopleRecordCollection::getAll();
        //echo "Hello there ";
        //var_dump($peopleRecords);
        $record->setHusbandAndWifeName($peopleRecords);
        $decoded_ids = json_decode($record->getChildrenIDs());
        //var_dump($decoded_ids);
        $record->setChildrenNames($peopleRecords);
        return $record;
    }
}