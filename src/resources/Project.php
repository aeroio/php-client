<?php

require_once 'src/Resource.php';

/**
 * Aero_Project class.
 *
 * Resource that has coresponding records in the database, which are with
 * the supplied in the schema format.
 */
class Aero_Project extends Aero_Resource {

    /**
     * Schema, containing the attributes that this record should have.
     *
     * @var array
     */
    protected $schema = array(
        'id',
        'title',
        'description',
        'created_at',
        'updated_at'
    );

    /**
     * The actual attributes of the record with their values.
     *
     * @var array
     */
    protected $attributes = array();

    /**
     * Assemble the relative path that should be requested.
     *
     * @return string
     */
    public function path() {
        $url = '/projects';

        if ($this->id) {
            $url .= "/$this->id";
        }

        return $url;
    }
}

Aero_Connection::$engine = new Aero_Http();
Aero_Connection::$credentials = array(
    'auth_token' => '52b8963d43b3f9081f58977b5aa3c110',
    'sid' => '4ced755889ec99408be287e3ffb83b6b'
);

$project = Aero_Project::all();
print_r($project);
?>
