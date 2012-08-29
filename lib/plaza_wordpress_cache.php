<?php

  /** 
   * Project:    Plaza-PHP
   * File:       mysql_cache.php
   *
   * @author Wes Hays <wes@onthecity.org> 
   * @link https://github.com/thecity/thecity-plaza-php
   * @package TheCity
   */


  

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
      $this->expire_cache($key);
      if( is_null($expire_in) ) { $expire_in = 30; } # 3600 seconds = 1 hour
      $expire_in += time();
      $t = date("Y-m-d H:i:s", $expire_in);
      $this->db_conn->insert($this->table_name, array('cache_key' => $key, 'cache_value' => serialize($data), 'cache_expire_at' => $t));
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
      $result = $this->db_conn->get_results('SELECT cache_value FROM '.$this->table_name.' WHERE cache_key = "'.$key.'" AND cache_expire_at >= "'.$t.'"LIMIT 1');
      if( empty($result) ) { 
        $this->expire_cache($key); // Just make sure
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
      $this->db_conn->get_results('DELETE FROM '.$this->table_name.' WHERE cache_key = "'.$key.'"');
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
      $result = $this->db_conn->get_results('SELECT id FROM '.$this->table_name.' WHERE cache_key = "'.$key.'" AND cache_expire_at >= "'.$t.'"LIMIT 1');
      return empty($result);  
    }
    

    
  }
?>
