<?php 

/*
      Read a Json file and insert it To MySql database
      - Reads the json data from file
      - Divides the data into chunks / parts / shard
      - inserts the data in chunks
*/
      require 'inc/cons.php'; 
      $uploaddir = 'uploads/';
      $uploadfile = $uploaddir . basename($_FILES['dv-file']['name']);
      echo '<pre>';
      if (move_uploaded_file($_FILES['dv-file']['tmp_name'], $uploadfile)) {            
            $filename = $uploadfile;              
            $fp = fopen($filename, "r");
            $content = fread($fp, filesize($filename));
            $lines = explode("\n", $content);
            fclose($fp);
            ini_set('memory_limit', '-1');
            set_time_limit(2000); 
            $jsondata = json_decode($content,true);  
            $shardSize = 3000;
            $sql = '';
      
            foreach($jsondata as $property => $row) 
            {    
                  if ($property % $shardSize == 0) {
                        if ($property != 0) {
                            $sql_1 = $conn->prepare($sql); 
                            $sql_1->execute(); 
                        }  
                        $sql = 'INSERT INTO `json_data` (`data_ts`,`data_val`) VALUES ';                        
                    }
                    $sql .= (($property % $shardSize == 0) ? '' : ', ') . "('{$row['ts']}',  '{$row['val']}')"; 
            }
            echo "File was successfully uploaded.";
      } else {
            echo "Possible file upload attack!";
      }
      print "</pre>";
?>