<?php
    if (!defined('PERCH_DB_PREFIX')) exit;
    
    // DB tables 
    $sql = file_get_contents(__DIR__.'/db.sql');
    $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);
    
    $statements = explode(';', $sql);
    foreach($statements as $statement) {
        $statement = trim($statement);
        if ($statement!='') $this->db->execute($statement);
    }



    // App Privilages
    $API = new PerchAPI(1.0, 'pipit_shortcuts');
    $UserPrivileges = $API->get('UserPrivileges');
    $UserPrivileges->create_privilege('pipit_shortcuts', 'Access the Shortcuts app');