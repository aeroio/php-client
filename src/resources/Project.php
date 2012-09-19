<?php

require_once 'src/Resource.php';

class Aero_Project extends Aero_Resource {
    public $id;
    public $title;
    public $description;
    public $created_at;
    public $updated_at;

    /**
     * TODO: use schema
     */
    protected $schema = array(
        'id',
        'title'
        'description'
    );

    protected $attributes = array();
}

?>
