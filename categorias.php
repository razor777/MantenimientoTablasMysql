<?php
  $registros = array();
   $lasInsertID=0;
   
     //Realizar la conexion con MySQL
    $conn = new mysqli("127.0.0.1", "root", " ", "new2015NW");
    if($conn->errno){
      die("DB no can: " . $conn->error);
    }
   
  if(isset($_POST["btnIns"])){
    $registro = array();
    $registro["descripcion"] = $_POST["ctgdsc"];
    $registro["estado"] = $_POST["ctgest"];
  
    //Preparar el Insert Statement
    $sqlinsert ="INSERT INTO `categorias` ( `ctgdsc`, `ctgest`)";
    $sqlinsert.="VALUES ('". $registro["descripcion"] ."' , '". $registro["estado"] ."');";
    //Ejecutar el Insert Statement
    $result = $conn->query($sqlinsert);
    //Obtener el último codigo generado
  }
  
  if(isset($_POST["btnUps"])){
   
    
    $ssql="UPDATE `categorias` SET  `ctgid`='{$_POST['ctgid']}', `ctgdsc`='{$_POST['ctgdsc']}',`ctgest`='{$_POST['ctgest']}' WHERE `ctgid`='{$_POST['ctgid']}'";
    $result = $conn->query($ssql);
  }
  

    $lasInsertID= $conn->insert_id;
  
  $sqlQuery="Select * from categorias;";
  $resulCursor=$conn->query($sqlQuery);
  
 while($registro = $resulCursor->fetch_assoc()){
      $registros[] = $registro;
     

    }
  
  
  //Obtener los registros de la tabla
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Formulario de Categorias</title>
  </head>
  <body>
    <h1>Categorias</h1>
    <form action="cat.php" method="POST">
        <label for="ctgdsc">Descripción</label>
        <input type="text" name="ctgdsc" id="ctgdsc" value="<?php echo $registro["descripcion"] = $_POST["ctgdsc"]?>" />
        <br/>
        <label for="ctgest">Estado</label>
        <select name="ctgest" id="ctgest" value="<?php echo $registro["estado"] = $_POST["ctgest"]?>">
            <option value="PND">Pendiente</option>
            <option value="CNF">Confirmado</option>
            <option value="CNL">Cancelado</option>
        </select>
        <br/>
        <input type="submit" name="btnIns" value="Guardar" />
        <br/>
         <label for="ctgid">Id para actualizar</label>
        <input type="text" name="ctgid" id="ctgid" />
        <input type="submit" name="btnUps" value="Actualizar" />
    </form>
    <div>
      <h2>Datos</h2>
      
      <table>
        <tr>
          <th>Codigo</th>
          <th>Descripción</th>
          <th>Estado</th>
        </tr>
        <?php
        if(count($registros)>0){
          foreach($registros as $registro){
              
              echo "<tr><td>".$registro["ctgid"]."</td>";
              echo "<td>".$registro["ctgdsc"]."</td>";
              echo "<td>".$registro["ctgest"]."</td></tr>";
        
            
          }
        }
      
        ?>
      </table>
    </div>
  </body>
</html>