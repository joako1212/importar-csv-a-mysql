<?php
$server="localhost";
$user="root";
$password="";

$ext=".csv";
$file="documento".$ext;
$handle = fopen($file, "r");

if($handle){
    $column_headers = array(); 
    $row_count = 0; 
    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE)
    {
      if ($row_count==0){ $column_headers = $data; 
      }
      else
      {
          $num = count($data);
          for ($c=0; $c<$num; $c++) 
          {
              $arr = explode(';', $data[$c]);
              $nombre = utf8_encode($arr[0]);
              $apellido = utf8_encode($arr[1]);
              $correo = utf8_encode($arr[2]);
              $sexo = utf8_encode($arr[3]);
              $edad = utf8_encode($arr[4]);
              
              
              //ENVIAR A LA BD
              
              $mysql = mysqli_connect($server, $user, $password) 
              or die("error");
              mysqli_select_db($mysql, 'practica');
              mysqli_set_charset($mysql,"utf8");
              $sql=("insert into clientes (nombre,apellido,correo, sexo,edad)  
              values ('$nombre', '$apellido', '$correo','$sexo', '$edad')") or die(mysql_error());
              if (mysqli_query($mysql , $sql)) 
              {
                  //echo "LOS DATOS HAN SIDO ENVIADOS CORRECTAMENTE"
              }
              else 
              {
                    echo "Error: " . $sql . "<br>" . mysqli_error($mysql);
              }
               
          }
      } 
      ++$row_count; 
  }
  } 
?>
