<?php
class PersonRecord
{
    private $person_key = "";
    private $first_name = "";
    private $last_name = "";
    private $birth_date = "";
    private $birth_place = "";
    private $death_date = "";
    private $death_place = "";
    private $gender = "";
    private $fams = "";
    private $famc = "";
    private $person_id = "";

    public function getPersonKey()
    {
        return $this->person_key;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }
    public function getFullName()
    {
        if ($this->first_name === "undefined") {
            return "Unknown {$this->last_name}";
        }
        return "{$this->first_name} {$this->last_name}";
    }
    public function getBirthDate()
    {
        return $this->birth_date;
    }
    public function getBirthPlace()
    {
        return $this->birth_place;
    }
    public function getDeathDate()
    {
        return $this->death_date;
    }
    public function getDeathPlace()
    {
        return $this->death_place;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function getFams()
    {
        return $this->fams;
    }
    public function getFamc()
    {
        return $this->famc;
    }
    public function getPersonID()
    {
        return $this->person_id;
    }

    public function outputSpouse($family)
    {
    }
}