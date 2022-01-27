<?php

    function getDBconfig() {

        if(getenv('DATABASE_URL') != "") {
            $dbOption = parse_url(getenv('DATABASE_URL'));
            $type = "pgsql";
            $servername = $dbOption["host"];
            $username = $dbOption["user"];
            $password = $dbOption["pass"];
            $dbName = ltrim($dbOption["path"], '/');

            return [$servername, $username, $password, $dbName, $type];

        } else {
            $type = "mysql";
            $servername = "localhost";
            $username = "test";
            $password = "hackerman";
            $dbName = "themeparkdb";

            return [$servername, $username, $password, $dbName, $type];

        }
    }

?>