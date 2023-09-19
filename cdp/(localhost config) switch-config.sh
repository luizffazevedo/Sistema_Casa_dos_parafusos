#!/bin/bash

# Set the environment variable
export CI_ENV=$1

# Set the database credentials for each environment
case $CI_ENV in
  "production")
    hostname=""
    username=""
    password=""
    database=""
    ;;
  "hmg")
    hostname=""
    username=""
    password=""
    database=""
    ;;
  "dev")
    hostname=""
    username=""
    password=""
    database=""
    ;;
esac

# Copy the appropriate configuration files to the CodeIgniter config directory
cat > application/config/database.php <<EOF
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
\$active_group = 'default';
\$query_builder = TRUE;

\$db['default'] = array(
	'dsn'	=> 'mysql:host=${hostname};dbname',
	'hostname' => '',
	'username' => '${username}',
	'password' => '${password}',
	'database' => '',
	'dbdriver' => 'pdo',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
EOF