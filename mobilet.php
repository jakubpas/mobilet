<?php
/**
 * @author Jakub Pas
 */
namespace JakubPas;

$app = new Mobilet();
$app->report('mobilet');

class Mobilet
{
    public function csvToAssocArray($file)
    {
      return array_map(function($v){return str_getcsv($v, "\t");}, file($file));
    }

    public function report($file)
    {
        echo "Daty parkowania w sobote:\n";
        $totalAmount = floatval(0);
        $rows = $this->csvToAssocArray(__DIR__ . '/' . $file . '.csv');
        foreach ($rows as $row) {
            $date = \DateTime::createFromFormat('d.m.y H:i', $row[1]);
            if ( $date->format('N') == 6 AND preg_match('/Poznań SPP/',$row[2])) {
                echo $row[1].' '.$row[2].' '.$row[3]."\n";
                $amount = floatval(preg_replace('/,/','.',substr($row[3],0,-4)));
                $totalAmount+=$amount;
            }
        }
        echo "Razem: ".$totalAmount." zł\n";
    }
}