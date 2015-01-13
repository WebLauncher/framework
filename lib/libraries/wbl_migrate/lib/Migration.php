<?php
/**
 * Migration Object
 */
 
/**
 * Migration Object
 * @package WebLauncher\Objects
 */
class Migration extends Base {
    /**
     * string $up_file file uset for up migration
     */
    public $up_file = '';
    /**
     * string $down_file file used for down migration
     */
    public $down_file = '';
    
    /**
     * Constructor
     */
    function __construct() {                
        if (!$this -> up_file)
            $up_file = __DIR__.'/'.get_class($this) . '.up.sql';
        if (!$this -> down_file)
            $up_file = __DIR__.'/'.get_class($this) . '.down.sql';
    }

    /**
     * Up method
     */
    function up() {

    }
    
    /**
     * Down method
     */
    function down() {

    }
    
    /**
     * Before migration is run
     * @param string $direction
     */
    function before($direction='up'){
        
    }
    
    /**
     * After migration is run
     * @param string $direction
     */
    function after($direction='up'){
        
    }
    
    /**
     * Run migration
     * @param string $direction
     */
    function run($direction = 'up') {
        $this->before($direction);
        switch($direction) {
            case 'up' :
                $this->up();
                if (file_exists($this -> up_file))
                    $this -> query(file_get_contents($this -> up_file));
                break;
            case 'down' :   
                $this->down();             
                if (file_exists($this -> up_file))
                    $this -> query(file_get_contents($this -> up_file));
                break;
        }
        $this->after($direction);
        return true;
    }
}
?>