<?php

namespace orm\connection;

class Config
{
    /**
     * @connectionString array of string This attribute is internal for save the connection string
     */
    private $_connectionString = [];

    /**
     * @username array of string This attribute is internal for save the connection usernames
     */
    private $_username = [];

    /**
     * @password array of string This attribute is internal for save the connection passwords
     */
    private $_password = [];

    /**
     * List of drivers sets on connections
     * @var $_driver
     */
    private $_driver = [];

    /**
     * List of drivers sets on connections
     * @var $_driver
     */
    private $_charset = [];

    /**
     * Constant to define set accepted drivers.
     */
    const DRIVERS = [
        "msyql",
        "pgsql",
    ];

    private $default = null;

    /**
     * Create configuration from connection
     * @param string $driver The driver from connection
     * @param string $username The username from connection
     * @param string $password The password from connection
     * @param string $host The host from connection
     * @param string $database The database from connection
     * @param string $connectionName The connection name from connection
     * @param integer $port The port from connection
     * @return $this This object for other iterators
     * @throws \Exception case one or some elements on parameters are invalid
     */
    public function addConfig($driver = 'mysql', $username = "root", $password = null, $host = "localhost", $database = null, $connectionName = null, $port = null, $charset = 'utf8')
    {

        #Begin: Verify if all parameters send is valid.
        if (!is_string($driver) and !array_search($driver, DRIVERS)) throw new \Exception("The driver $driver don't supported.");
        if (!is_string($username)) throw new \Exception("Invalid username.");
        if (!is_string($password)) throw new \Exception("Invalid password.");
        if (!is_string($host)) throw new \Exception("Invalid host.");
        if (!is_string($database)) throw new \Exception("Invalid database name.");
        if (!is_string($connectionName)) throw new \Exception("Invalid connection name.");

        $port = is_null($port) ? '' : (int)$port;
        if (!is_null($port) && !is_int($port)) throw new \Exception("Invalid port format.");

        #Constructor of the connection string
        $this->_connectionString[$connectionName] = "$driver:host=$host;dbname=$database;port=$port;";
        $this->_username[$connectionName] = $username;
        $this->_password[$connectionName] = $password;
        $this->_driver[$connectionName] = $driver;
        $this->_charset[$connectionName] = $charset;

        return $this;
    }

    /**
     * Get all connection string
     * @return array if have connection but not have this method return null
     */
    final public function getConfigs()
    {
        return $this->_connectionString;
    }

    /**
     * Set the current connection on connection name.
     * @param string $connectionName name on connection
     * @return $this This object from other interator
     * @throws \Exception if the connect name haven't set;
     */
    public function setDefault($connectionName)
    {
        $this->default = $connectionName;
        return $this;
    }

    /**
     * Set the current connection on connection name.
     * @param string $connectionName name on connection
     * @return $this This object from other interator
     * @throws \Exception if the connect name haven't set;
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Set the current connection on connection name.
     * @param string $connectionName name on connection
     * @return $this This object from other interator
     * @throws \Exception if the connect name haven't set;
     */
    public function getConnection($connectionName)
    {
        if (!is_string($connectionName)) throw new \Exception("Invalid connection name.");

        if (array_key_exists($connectionName, $this->_connectionString)) {
            return [
                'connectionString' =>$this->_connectionString[$connectionName],
                'driver' => $this->_driver[$connectionName],
                'username' => $this->_username[$connectionName],
                'password' => $this->_password[$connectionName],
                'charset' => $this->_charset[$connectionName]];
        } else {
            throw new \Exception("The connection name $connectionName is not set.");
        }

        return $this;
    }


    /**
     * Get name on current connection
     * @return string name on current connection or null if don't have
     */
    final public function getCurrentConnectionName()
    {
        return $this->_currentConnectionName;
    }

}