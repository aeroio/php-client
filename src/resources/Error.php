<?php

require_once 'src/Resource.php';

class Aero_Error extends Aero_Resource {
    public $id;
    public $project_id;
    public $message;
    public $occured;
    public $resolved;
    public $created_at;
    public $updated_at;

    // TODO: use this
    public function path() {
        return str_replace('/projects/:project_id/errors', ':project_id', $this->getProjectId());
    }
}

?>
