<?php

namespace App\Controllers\Jobs;

use App\Controllers\Jobs\JobInstance;

class Jobs implements JobsInterface {

    private $instance = [];

    private function getInstance(): Array
    {
        return $this->instance;
    }

    public function setJobsData(Array $jobs = []): void
    {
        if(isArrayNotEmpty($jobs)){

            $jobsData['title'] = [];
            $jobsData['id'] = array_column($jobs, 'id');
            $jobsData['cities'] = array_column($jobs, 'cities');

            for ($i=0; $i < $count = sizeof($jobs); $i++) { 
                    array_push($jobsData['title'], array_column($jobs[$i], 'title'));
            }

            foreach ($jobsData['id'] as $key => $id) {

                $JobData = ['id' => $id,'title' => $jobsData['title'][$key][0], 'cities' => $jobsData['cities'][$key]];

                array_push($this->instance, new JobInstance($JobData));
            }

            // /$jobArrayKey = array_keys(get_object_vars($this));        
        }
    }

    public function getAllData()
    {
        return $this->getInstance();
    }
}
