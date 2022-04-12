<?php
class StoryCollection
{
    public static function getAll()
    {
        $query = "
            SELECT * FROM stories
            ORDER BY date_added
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $results = $pdo->query($query)->fetchAll(PDO::FETCH_CLASS, 'Story');
            return $results;
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }

        $pdo = null;
    }

    public static function get($story_key)
    {
        $query = "
            SELECT
            stories.story_key,
            stories.summary,
            stories.story AS story_content,
            stories.date_of_story,
            stories.date_added    
        FROM
            `stories`
        WHERE stories.story_key = :story_key
        ";
        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam(':story_key', $story_key);

            $statement->execute();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
        $pdo = null;

        $statement->setFetchMode(PDO::FETCH_CLASS, "Story");
        $record = $statement->fetch();

        return $record;
    }

    public static function getPeopleForStory($story_key)
    {
        $query = "
            SELECT
            people.first_name,
            people.last_name,
            people.person_id
        FROM
            `people`
        INNER JOIN stories_people ON stories_people.person_key = people.person_key AND stories_people.story_key = :story_key
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam(':story_key', $story_key);

            $statement->execute();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
        $pdo = null;

        $statement->setFetchMode(PDO::FETCH_CLASS, "PersonRecord");
        $record = $statement->fetchAll();

        return $record;
    }

    public static function getByPerson($person_id)
    {
        $query = "
            SELECT
            stories.story_key,
            stories.summary,
            stories.story AS story_content,
            stories.date_of_story,
            stories.date_added
        FROM
            `stories`
        INNER JOIN stories_people ON stories_people.story_key = stories.story_key AND stories_people.person_key = :person_id
        ";
        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam(':person_id', $person_id);

            $statement->execute();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
        $pdo = null;

        $statement->setFetchMode(PDO::FETCH_CLASS, "Story");
        $record = $statement->fetchAll();

        return $record;
    }

    public static function create($summary, $story_content, $people_ids)
    {
        $query = "
            INSERT INTO stories (summary, story, date_added)
            VALUES(:summary, :story, :date_added)
        ";
        try {
            $pdo = DatabaseConnection::getConnection();
            $statement = $pdo->prepare($query);

            $date_added = date("Y-m-d");

            $statement->bindParam(':summary', $summary);
            $statement->bindParam(':story', $story_content);
            $statement->bindParam(':date_added', $date_added);

            $statement->execute();

            # get story ID
            $story_key = $pdo->lastInsertId();

            $linkedPeople = (!empty($people_ids) ? self::linkPeople($story_key, $people_ids) : true);
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }

        $pdo = null;

        return ($statement && $linkedPeople);
    }

    public static function update($story_key, $summary, $story_content, $people_ids)
    {
        $query = "
            UPDATE stories
            SET summary = :summary, story = :story_content
            WHERE story_key = :story_key
            LIMIT 1;
        ";
        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam('story_key', $story_key);
            $statement->bindParam(':summary', $summary);
            $statement->bindParam(':story_content', $story_content);

            $statement->execute();

            self::unlinkPeople($story_key);

            $linkedPeople = (!empty($people_ids) ? self::linkPeople($story_key, $people_ids) : true);
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }

        $pdo = null;

        return ($statement && $linkedPeople);
    }

    public static function remove($story_key)
    {
        $query = "
            DELETE FROM stories
            WHERE story_key = :story_key
            LIMIT 1;
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam(':story_key', $story_key);

            $statement->execute();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
        $pdo = null;

        return $statement;
    }

    private static function linkPeople($story_key, $people_keys)
    {
        $query = "
            INSERT INTO stories_people (story_key, person_key)
            VALUES(:story_key, :person_key)
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            foreach ($people_keys as $person_key) {
                $statement->bindParam(':story_key', $story_key);
                $statement->bindParam(':person_key', $person_key);

                $statement->execute();
            }
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }

        $pdo = null;

        return $statement;
    }

    private static function unlinkPeople($story_key)
    {
        $query = "
            DELETE FROM stories_people
            WHERE story_key = :story_key
            LIMIT 1;
        ";

        try {
            $pdo = DatabaseConnection::getConnection();

            $statement = $pdo->prepare($query);

            $statement->bindParam(':story_key', $story_key);

            $statement->execute();
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
        $pdo = null;

        return $statement;
    }
}