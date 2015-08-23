<?php
/**
 * Created by IntelliJ IDEA.
 * User: Bruijnes
 * Date: 21/08/15
 * Time: 04:10
 */

namespace love9;


class PeopleGrid
{
    private $people = [],
            $page,
            $pages,
            $recordCount;

    public function __construct($page = 1)
    {
        $this->pagination($page);
        $this->retrievePeople($this->page);
    }

    private function pagination($page)
    {
        $totalRecords = $this->totalNumberOfRecords();
        $this->pages = intval(ceil($totalRecords / 9));

        if ($page > $this->pages)
        {
            $this->page = 1;
        }
        else {
            $this->page = $page;
        }
    }

    public function showPeopleGrid()
    {
        global $user;
        require TEMPLATES . 'people-grid.php';
    }

    private function retrievePeople($page)
    {
        $modifier = $page - 1;
        $offset = $modifier * 9;
        try {
            global $db;
            $people = $db->prepare('
                SELECT p.personId
                FROM People p
                ORDER BY p.name
                LIMIT ?, 9
            ');
            $people->bindParam(1, $offset, \PDO::PARAM_INT);
            $people->execute();
            $people = $people->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($people as $person)
                array_push($this->people, Person::withId($person['personId']));
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'People retrieval');
        }
    }

    private function totalNumberOfRecords() {
        try {
            global $db;
            $amount = $db->query('
                SELECT COUNT(*) AS noOfPeople
                FROM People
            ');
            $amount = $amount->fetch(\PDO::FETCH_ASSOC)['noOfPeople'];
            $this->recordCount = $amount;
            return $amount;
        }
        catch (\Exception $e) {
            global $exceptionHandler;
            $exceptionHandler->databaseException($e, 'People amount');
        }
    }

    public static function fromQuery($query, $page) {
        // TODO: Search
    }
}