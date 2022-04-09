<?php
class PeopleRecordCollection
{
    public static function getAll()
    {
        $query = "
             SELECT p.person_key,
                    p.first_name, 
		            p.last_name,
                    p.birth_date,
                    p.birth_place,
                    p.death_date,
                    p.death_place,
                    p.gender,
                    p.fams,
                    p.famc,
                    p.person_id
               FROM `people` AS p
           ORDER BY p.person_key;
        ";
        try {
            $pdo = DatabaseConnection::getConnection();

            $results = $pdo->query($query)->fetchAll(PDO::FETCH_CLASS, 'PersonRecord');
            return $results;
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }

    public static function get($person_id)
    {
        $query = "
         SELECT p.person_key,
                p.first_name, 
                p.last_name,
                p.birth_date,
                p.birth_place,
                p.death_date,
                p.death_place,
                p.gender,
                p.fams,
                p.famc,
                p.person_id
           FROM `people` AS p
           WHERE p.person_id = :person_id
           LIMIT 1;
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam(':person_id', $person_id);

            $statement->execute();
        } catch (PDOException $exception) {
            // exit($exception->getMessage());
        }
        $pdo = null;

        $statement->setFetchMode(PDO::FETCH_CLASS, "PersonRecord");

        return $statement->fetch();
    }
}