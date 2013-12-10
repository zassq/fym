<?php

class Excel{

    function to_excel($array, $filename) {
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');

        if(is_object($array)) $array = (array)$array;

        # first row as header
        $h = array();
        foreach($array as $row){
            foreach($row as $k => $v){
                if(!in_array($k, $h)){
                    $h[] = $k;
                }
            }
        }

        # echo table headers
        echo '<table><tr>';
        foreach($h as $key) {
            $key = iconv("UTF-8", "gb2312//IGNORE", $key);
            echo '<th>'.$key.'</th>';
        }
        echo '</tr>';

        foreach($array as $row){
            echo '<tr>';
            foreach($row as $v){
                $this->writeRow($v);
            }
            echo '</tr>';
        }
        echo '</table>';


        #Filter all keys, they'll be table headers
        /*
         * $h = array();
        foreach($array->result_array() as $row){
            foreach($row as $key=>$val){
                if(!in_array($key, $h)){
                    $h[] = $key;
                }
            }
        }
        //echo the entire table headers
        echo '<table><tr>';
        foreach($h as $key) {
            $key = ucwords($key);
            echo '<th>'.$key.'</th>';
        }
        echo '</tr>';

        foreach($array->result_array() as $row){
            echo '<tr>';
            foreach($row as $val)
                $this->writeRow($val);
        }
        echo '</tr>';
        echo '</table>';
        */
    }

    function writeRow($val) {
        #echo '<td>'.utf8_decode($val).'</td>';
        echo '<td>'.iconv("UTF-8", "gb2312//IGNORE", $val).'</td>';
    }

}

?>