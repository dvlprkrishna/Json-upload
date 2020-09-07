<?php
      $uploaddir = 'uploads/';
      $uploadfile = $uploaddir . basename($_FILES['dv-file']['name']);

      echo '<pre>';
      if (move_uploaded_file($_FILES['dv-file']['tmp_name'], $uploadfile)) {
 
            
            $filename = $uploadfile;
              
            $fp = fopen($filename, "r");
            $content = fread($fp, filesize($filename));
            $lines = explode("\n", $content);
            fclose($fp);
            $jsondata = json_decode($content,true);

             
 
 
            $i = 0;
            foreach($jsondata as $property => $item) 
            {    
                  echo '' . $item['ts'] . "\n";
                  echo '' . $item['val'] . "\n";                    

                  $i++;
            }              

            echo gettype($jsondata);

              

            echo "File is valid, and was successfully uploaded.\n\n  ";
      } else {
            echo "Possible file upload attack!\n";
      }

      echo 'Here is some more debugging info:\n';
      print_r($_FILES);

      print "</pre>";
?>