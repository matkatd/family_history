<?php
class Story
{
    private $story_key;
    private $summary;
    private $story_content;
    private $date_of_story = "";
    private $date_added;
    private $associated_people = [];
    private $associated_images = [];

    public function getKey()
    {
        return $this->story_key;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function getStoryContent()
    {
        return $this->story_content;
    }

    public function getDateOfStory()
    {
        return $this->date_of_story;
    }

    public function getDateAdded()
    {
        return $this->date_added;
    }

    public function getAssociatedPeople()
    {
        return $this->associated_people;
    }

    public function getImages()
    {
        return $this->associated_images;
    }
}