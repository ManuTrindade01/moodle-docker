<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

// [CORREÇÃO 1] Faz o Moodle ler as variáveis de ambiente
// que definimos no docker-compose.yml
$CFG->dbtype    = getenv('MOODLE_DOCKER_DBTYPE'); // postgres
$CFG->dblibrary = 'native';
$CFG->dbhost    = getenv('MOODLE_DOCKER_DBHOST'); // pgbouncer
$CFG->dbname    = getenv('MOODLE_DOCKER_DBNAME'); // moodle
$CFG->dbuser    = getenv('MOODLE_DOCKER_DBUSER'); // moodle
$CFG->dbpass    = getenv('MOODLE_DOCKER_DBPASS'); // m@0dl3ing
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  // [CORREÇÃO 2] Lê a porta correta (6432) do pgbouncer
  'dbport' => getenv('MOODLE_DOCKER_DBPORT'), 
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$host = 'localhost';
if (!empty(getenv('MOODLE_DOCKER_WEB_HOST'))) {
    $host = getenv('MOODLE_DOCKER_WEB_HOST');
}
$CFG->wwwroot   = "http://{$host}";
$port = getenv('MOODLE_DOCKER_WEB_PORT'); // 8080
if (!empty($port)) {
    // Extract port in case the format is bind_ip:port.
    $parts = explode(':', $port);
    $port = end($parts);
    if ((string)(int)$port === (string)$port) { // Only if it's int value.
        $CFG->wwwroot .= ":{$port}";
    }
}

$CFG->dataroot  = '/var/www/moodledata';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');