<?php

  /** 
   * Project:    Plaza-PHP
   * File:       mysql_cache.php
   *
   * @author Wes Hays <wes@onthecity.org> 
   * @link https://github.com/thecity/thecity-plaza-php
   * @package TheCity
   */



define("THE_CITY_PLAZA_CACHE_TABLE_VERSION", 1);
define("THE_CITY_PLAZA_CACHE_TABLE_OPTION_KEY", 'the_city_plaza_key');


  /** 
   * This class caches the data in a mysql database.
   *
   * @package TheCity
   */
  class PlazaWordPressCache implements CacheInterface {
    
    // The subdomain to load and store the data for.
    private $subdomain;

    // The database connection WordPress is using.
    private $db_conn;

    // The database table used to cache the data.
    private $table_name;
    
    
    /**
     *  Constructor.
     *
     * @param string $subdomain The church subdomain.
     * 
     */
    public function __construct($subdomain) {
      $this->subdomain = $subdomain;
    }
    

    /** 
     * Set the database connection that WordPress uses.
     *
     * @param WordPressDBConnection conn The wordpress database connection
     *
     */
    public function set_db_connection($conn) {
      $this->db_conn = $conn;
      $this->table_name = $conn->prefix . 'thecity_json_cache';
      $this->create_the_city_cache_table_unless_exists();
    }


    /** 
     * Checks if the cache table exists and if not creates it.
     */
    public function create_the_city_cache_table_unless_exists() {      

      $build_table = false;
      if($this->db_conn->get_var("SHOW TABLES LIKE '".$this->table_name."'") != $this->table_name) {
        $build_table = true;
      } else {        
        $result = $this->db_conn->get_results('SELECT cache_value FROM '.$this->table_name.' WHERE cache_key = "'.THE_CITY_PLAZA_CACHE_TABLE_OPTION_KEY.'" LIMIT 1'); 
        $key = 0;
        if(!empty($result)) { $key = $result[0]->cache_value; } 
        if($key != THE_CITY_PLAZA_CACHE_TABLE_VERSION) {
          $build_table = true;
        }
      }

      if($build_table) {
        $sql = "DROP TABLE IF EXISTS ".$this->table_name;
        $this->db_conn->query($sql);

        $charset_collate = '';
        if(!empty($this->db_conn->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET ".$this->db_conn->charset;
        }
        
        if(!empty($this->db_conn->collate)) {
            $charset_collate .= " COLLATE ".$this->db_conn->collate;
        }

        $sql = "CREATE TABLE IF NOT EXISTS ".$this->table_name." (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                cache_key VARCHAR(255) NOT NULL,
                cache_value mediumtext NOT NULL,
                cache_expire_at TIMESTAMP NOT NULL,
                UNIQUE KEY id (id)
                ) ".$charset_collate.";";
        $this->db_conn->query($sql);

        $this->db_conn->insert($this->table_name, array('cache_key' => THE_CITY_PLAZA_CACHE_TABLE_OPTION_KEY, 
                                                        'cache_value' => THE_CITY_PLAZA_CACHE_TABLE_VERSION, 
                                                        'cache_expire_at' => '0000-00-00 00:00:00'));
      }
    }  

    
    /**
     *  Save data to the cache.
     *
     * @param string $key The key to use to save the cache.
     * @param string $data The JSON data to be saved.
     * @param string $expire_in The number of seconds to pass before expiring the cache.
     *
     * @return mixed Returns true on success or a string error message on false.
     */
    public function save_data($key, $data, $expire_in = null) {
      $this->expire_cache($this->subdomain.'::'.$key);
      if( is_null($expire_in) ) { $expire_in = 3600; } # 3600 seconds = 1 hour
      $expire_in += time();
      $t = date("Y-m-d H:i:s", $expire_in);
      $this->db_conn->insert($this->table_name, array('cache_key' => $this->subdomain.'::'.$key, 'cache_value' => serialize($data), 'cache_expire_at' => $t));
      return true;      
    } 
    
    

    /**
     * Get the data from the cache.
     *
     * @param string $key The key to use to get the cache.
     *
     * @return JSON data.
     */
    public function get_data($key) {         
      $t = date("Y-m-d H:i:s", time());
      $result = $this->db_conn->get_results('SELECT cache_value FROM '.$this->table_name.' WHERE cache_key = "'.$this->subdomain.'::'.$key.'" AND cache_expire_at >= "'.$t.'"LIMIT 1');
      if( empty($result) ) { 
        $this->expire_cache($this->subdomain.'::'.$key); // Just make sure
        return null; 
      }
      return unserialize($result[0]->cache_value);
    }
    
    
    /**
     * Expire the cache.
     *
     * @param string $key The key to use to expire the cache.
     *
     * @throws Exception if unable to remove cache file.
     */
    public function expire_cache($key) {
      $this->db_conn->get_results('DELETE FROM '.$this->table_name.' WHERE cache_key = "'.$this->subdomain.'::'.$key.'"');
    }
    
    
    /**
     * Check if the cache has expired.
     *
     * @param string $key The key to use to check if the cache has expired.
     *
     * @return boolean If the cache does not exist or is expired then true, otherwise false.
     */
    public function is_cache_expired($key) {
      $t = date("Y-m-d H:i:s", time());
      $result = $this->db_conn->get_results('SELECT id FROM '.$this->table_name.' WHERE cache_key = "'.$this->subdomain.'::'.$key.'" AND cache_expire_at >= "'.$t.'"LIMIT 1');
      return empty($result);  
    }
    

    /**
     * Clears the cache.
     *
     * @return boolean If the cache clears successfully then true, otherwise false.
     */
    public function clear_cache() {
      $this->db_conn->get_results('DELETE FROM '.$this->table_name.' WHERE cache_key != "'.THE_CITY_PLAZA_CACHE_TABLE_OPTION_KEY.'"');
      return true; 
    }    

    
  }
?>
