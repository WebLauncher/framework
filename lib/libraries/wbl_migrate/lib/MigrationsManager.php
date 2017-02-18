<?php
/**
 * Migrations processing
 */

/**
 * Migrations processing
 * @package WebLauncher\Managers
 */
class MigrationsManager {
    /**
     * @var System null
     */
    public $system = null;
    private $_migrations = array();
    private $_old_migrations = array();
    /**
     * Constructor
     */
    function __construct() {
    }

    /**
     * Run migrations up
     * @param string $direction
     */
    function run($direction = 'up') {
        $RD = $this -> system -> paths['root_dir'];
        $FD = $RD . $this -> system -> files_folder;
        // get registered migrations
        $this -> _migrations =
        require_once $RD . 'db/migrations.php';
            
        // look for version file
        if (file_exists($FD . 'migrations_versions.json'))
            $this -> _old_migrations = json_decode(file_get_contents($FD . 'migrations_versions.json'), true);
        end($this->_old_migrations);
        if(count($this->_old_migrations))
            echopre('Current version: '.key($this->_old_migrations));
        reset($this->_old_migrations);
        $run = false;        
        $state = array();
        if ($direction == 'all') {
            foreach ($this->_migrations as $ver => $name)
                if (!isset($this -> _old_migrations[$ver])) {
                    if($this -> run_migration($name, $ver, 'up'))
                    {
                        $run = true;
                        $state[$ver]=$name; 
                    }
                    else
                        break;
                }
                else {
                    $state[$ver]=$name;
                }
            $this -> save_state($state);
        } else {
            $migration = '';
            $version='';
            if ($direction == 'up')
                foreach ($this->_migrations as $ver => $name)
                    if (!isset($this -> _old_migrations[$ver]) && !$migration) {
                        $migration = $name;
                        $version=$ver;
                        $state[$ver] = $name;
                    } elseif (!$migration)
                        $state[$ver] = $name;
            if (!$migration && $direction == 'down') {
                if (count($this -> _old_migrations)) {
                    end($this->_old_migrations);
                    $version=key($this->_old_migrations);
                    $migration = array_pop($this -> _old_migrations);                    
                    $state = $this -> _old_migrations;
                }
            }
            if ($migration) {
                $this -> run_migration($migration, $version, $direction);
                $run = true;
            }
            $this -> save_state($state);
        }
        if (!$run && count($state)==count($this->_migrations))
            echopre('You are already up to date!');
    }

    /**
     * Save state into version file
     * @param $migrations
     * @internal param string $migration Migration file
     */
    function save_state($migrations) {
        file_put_contents($this -> system -> paths['root_dir'] . $this -> system -> files_folder . 'migrations_versions.json', json_encode($migrations));
    }

    function run_migration($name="", $version=0, $direction = 'up') {
        if(!$name){
            $RD = $this -> system -> paths['root_dir'];
            $this -> _migrations = require_once $RD . 'db/migrations.php';
            $name=$this->_migrations[$version];
        }
        echopre('[Version: '.$version.'] Running: '.$direction.' => ' . $name);
        if (file_exists($this -> system -> paths['root_dir'] . 'db/migrations/' . $name . '.sql')) {
            if($direction=='up'){
                echopre('Found '.$this -> system -> paths['root_dir'] . 'db/migrations/' . $name . '.sql');
                $query = file_get_contents($this -> system -> paths['root_dir'] . 'db/migrations/' . $name . '.sql');
                if ($query)
                    $this -> system -> db_conn -> query($query);
            }
            return true;
        } elseif (file_exists($this -> system -> paths['root_dir'] . 'db/migrations/' . $name . '.php')) {
            require_once $this -> system -> paths['root_dir'] . 'db/migrations/' . $name . '.php';
            echopre('Found '.$this -> system -> paths['root_dir'] . 'db/migrations/' . $name . '.php');
            $object = new $name();
            return $object -> run($direction);
        } else
            System::triggerError('Could not locate migration file for ' . $name);
        return false;
    }

}
?>