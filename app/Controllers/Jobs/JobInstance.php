<?php

namespace App\Controllers\Jobs;

class JobInstance {

    public $id;
    public $title;
    public $cities = [];

    public function __construct(Array $jobData = [])
    {   
        if(isArrayNotEmpty($jobData)){
            $this->setID($jobData['id']);
            $this->setTitle($jobData['title']);
            $this->setCities($jobData['cities']);
        }
    }

    private function setID(int $id): void
    {
        $this->id = $id ?? '';
    }

    private function setTitle(String $title): void
    {
        $this->title = $title ?? '';
    }

    private function setCities(Array $cities): void
    {
        $this->cities = $cities ?? array();
    }
    /*
    public function getData()
    {
        return get_object_vars($this);
    }
    */
}
