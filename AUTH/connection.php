<?php
    session_start();

    function dbPortInfo(){
        $dbport = "3306";
        return ($dbport);
    }
    
    function connect(){
        $dbserver = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $dbname = "gastrohub_db";
        $dbport = dbPortInfo();
        $link=mysqli_connect($dbserver,$dbuser,$dbpass,$dbname,$dbport) or die("Could not connect".mysqli_connect_error());
        return ($link);
    }

    function getData($sql){
        $link=connect();
        $result=mysqli_query($link,$sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            $rows=$row;
            return $rows;
        }
    }

    function getDataRows($sql){
        $link=connect();
        $result=mysqli_query($link,$sql);
        while ($row=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            $rows[]=$row;
        }
        if(!empty($rows)){
            return $rows;
        }
    }

    function setData($sql){
        $link=connect();
        if (mysqli_query($link,$sql)) {
            return true;
        } else {
            echo("<script>
                alert('Error '".mysqli_error($link).");
                </script>");
            return false;
        }
    }
?>