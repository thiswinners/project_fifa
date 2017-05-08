<?php
Namespace App;

require_once(__DIR__ . "/../DatabaseConnector.php");

Class PoulGenerator {

    private $dbc;

    public function __construct()
    {
        $this->dbc = Connect();
    }

    public function fetchTeams()
    {
        $sql = "SELECT * FROM `tbl_teams`";
        $allTeams = $this->dbc->query($sql)->fetchAll();
        return $allTeams;
    }

    function shuffle_assoc($allTeams)
    {
        $keys = array_keys($allTeams);
        shuffle($keys);
        $random = array();
        foreach ($keys as $key)
            $random[$key] = $allTeams[$key];

        return $random;
    }

    public function PoulMaker()
    {
        for ($i = 1; $i < 5; $i++)
        {
            $sql = "INSERT INTO `tbl_poules` (`name`) VALUES ('$i')";
            $this->dbc->query($sql);
        }
    }

    public function PoulFiller($allTeams)
    {
        $amountTeams = Count($allTeams)/4;

        $count = 0;
        for ($i = 1; $i < 5; $i++)
        {
            for ($j = 0; $j < $amountTeams; $j++)
            {
                $tempTeam = $allTeams[$count]['name'];
                if ($amountTeams == $count)
                {
                    break;
                }
                $count++;

                $sql = "UPDATE `tbl_teams` SET `poule_id` = '$i' WHERE `name` = $tempTeam";
                $this->dbc->query($sql);
            }
        }
    }
}