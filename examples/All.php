<?php

include_once '../lib/autoload.php';
include_once 'UsageModel.php';

/**
 *  This exemple need a model
 *  After example use Connection
 *  This example need of primary key defined and have data in attribute
 *
 *  1. Extends your model to class Model, using namespace orm\model\Model
 *
 *  2. Set the static attribute $primary_key in your model
 *      @var This is an string
 *
 *  3. Set the static attribute $table_name in your model
 *      @var This is an string
 *
 *  4. For get all data on current model
 *      @return Array with object if exists the data
 *      @return Array haven't data
 *
 */

use MocOrm\Connection\ConnectionManager;
use MocOrm\Usage\UsageModel;

try {
    /**
     * 3. Initialize the connection using static method ConnectionManager::initialize()
     * @param \Closure $connection
     * @return \ConnectionManager
     */
    $connectionManager = ConnectionManager::initialize(function ($config) {
        /**
         * Add the configurations using the method addConfig, accepts various configurations
         *      Arguments:
         *      - $config->addConfig('driver', 'user', 'password', 'host', 'database', 'connectionName', 'port', charset, schema);
         *      - Driver options ['mysql', 'pgsql'] -- Mysql, postgres
         * @return Config
         */
        $config->addConfig(
            'mysql',
            'user',
            'pass',
            'host',
            'database',
            'name',
            'port',
            'char');
    });
    /**
     *  4. For get all data on current model
     *      @return Array with object if exists the data
     *      @return Array haven't data
     */
    $usage = UsageModel::all();

    if(count($usage) > 0){
        echo '<pre>';
        var_dump($usage);
        echo '</pre>';
    }else{
        echo 'Haven\'t data for this Model.';
    }

} catch (Exception $e) {
    /**
     * All Exceptions
     */
    echo $e->getMessage();
}