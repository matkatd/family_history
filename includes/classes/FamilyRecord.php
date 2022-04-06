<?php
class FamilyRecord
{
    private $family_id;
    private $husband_id;
    private $husband_name;
    private $wife_id;
    private $wife_name;
    private $children_ids;
    private $children_names = [];

    public function getFamilyID()
    {
        return $this->family_id;
    }
    public function getHusbandID()
    {
        return $this->husband_id;
    }
    public function getHusbandName()
    {
        return $this->husband_name;
    }
    public function getWifeID()
    {
        return $this->wife_id;
    }
    public function getWifeName()
    {
        return $this->wife_name;
    }
    public function getChildrenIDs()
    {
        return $this->children_ids;
    }
    public function getChildrenNames()
    {
        return $this->children_names;
    }

    public function setHusbandAndWifeName($peopleRecords)
    {
        foreach ($peopleRecords as $person) {
            if ($person->getFams() == $this->family_id && $person->getGender() == 'M') {
                $this->husband_name = $person->getFullName();
            }
            if ($person->getFams() == $this->family_id && $person->getGender() == 'F') {
                $this->wife_name = $person->getFullName();
            }
        }
    }

    public function setChildrenNames($peopleRecords)
    {
        $decoded_ids = json_decode($this->children_ids);
        foreach ($peopleRecords as $person) {
            foreach ($decoded_ids as $childID) {
                //echo "are we here?";
                //echo "ref " . $childID->ref;
                //echo "famc " . $person->getFamc();
                if ($person->getPersonID() == $childID->ref) {
                    array_push($this->children_names, $person->getFullName());
                    //$this->children_names += $person->getFullName();
                }
            }
        }
    }
}
