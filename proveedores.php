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
    $registro["descripcion"] = $_POST["prvdsc"];
    $registro["email"] = $_POST["prvemail"];
    $registro["telefono"] = $_POST["prvtel"];
    $registro["contacto"] = $_POST["prvcont"];
    $registro["direccion"] = $_POST["prvdir"];
    $registro["status"] = $_POST["prvest"];
  
    //Preparar el Insert Statement
    $sqlinsert ="INSERT INTO `proveedores` ( `prvdsc`, `prvemail`, `prvtel`, `prvcont`, `prvdir`, `prvest`)";
    $sqlinsert.="VALUES ('". $registro["descripcion"] ."' , '". $registro["email"] ."' , '". $registro["telefono"] ."' , '". $registro["contacto"] ."' , '". $registro["direccion"] ."' , '". $registro["status"] ."');";
    //Ejecutar el Insert Statement
    $result = $conn->query($sqlinsert);
    //Obtener el último codigo generado
  }
  
    if(isset($_POST["btnUps"])){
   
    $ssql="UPDATE `proveedores` SET  `prvid`='{$_POST['prvid']}', `prvdsc`='{$_POST['prvdsc']}',`prvemail`='{$_POST['prvemail']}' ,`prvtel`='{$_POST['prvtel']}',`prvcont`='{$_POST['prvcont']}',`prvdir`='{$_POST['prvdir']}',`prvest`='{$_POST['prvest']}' WHERE `prvid`='{$_POST['prvid']}'";
    $result = $conn->query($ssql);
  }
      

  
  
    $lasInsertID= $conn->insert_id;
  
  $sqlQuery="Select * from proveedores;";
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
    <title>Tabla Proveedores</title>
  </head>
  <body>
    <h1>Proveedores</h1>
    <form action="prov.php" method="POST">
        <label for="prvdsc">Descripción</label>
        <input type="text" name="prvdsc" id="prvdsc" value="<?php echo $registro["descripcion"] = $_POST["prvdsc"]?>" />
        <br/>
        <label for="prvemail">Email</label>
        <input type="email" name="prvemail" id="prvemail" value="<?php echo $registro["email"] = $_POST["prvemail"]?>" />
        <br/>
        <label for="prvtel">Telefono</label>
        <input type="text" name="prvtel" id="prvtel" value="<?php echo $registro["telefono"] = $_POST["prvtel"]?>"/>
        <br/>
        <label for="prvcont">Contacto</label>
        <input type="text" name="prvcont" id="prvcont" value="<?php echo $registro["contacto"] = $_POST["prvcont"]?>"/>
        <br/>
        <label for="prvdir">Direccion</label>
        <input type="text" name="prvdir" id="prvdir" value="<?php echo $registro["direccion"] = $_POST["prvdir"]?>"/>
        <br/>
        <label for="prvest">Estado</label>
        <select name="prvest" id="prvest"value="<?php echo $registro["status"] = $_POST["prvest"]?>">
            <option value="PND">Pendiente</option>
            <option value="CNF">Confirmado</option>
            <option value="CNL">Cancelado</option>
        </select>
        <br/>
        <input type="submit" name="btnIns" value="Guardar" />
        <br/>
         <label for="prvid">Id para actualizar</label>
        <input type="text" name="prvid" id="prvid" />
        <input type="submit" name="btnUps" value="Actualizar" />
    </form>
    <div>
      <h2>Datos</h2>
      
      <table>
        <tr>
          <th>Codigo</th>
          <th>Descripción</th>
          <th>Email</th>
          <th>Telefono</th>
          <th>Contacto</th>
          <th>Direccion</th>
          <th>Estado</th>
        </tr>
        <?php
        if(count($registros)>0){
          foreach($registros as $registro){
              
              echo "<tr><td>".$registro["prvid"]."</td>";
              echo "<td>".$registro["prvdsc"]."</td>";
              echo "<td>".$registro["prvemail"]."</td>";
              echo "<td>".$registro["prvtel"]."</td>";
              echo "<td>".$registro["prvcont"]."</td>";
              echo "<td>".$registro["prvdir"]."</td>";
              echo "<td>".$registro["prvest"]."</td></tr>";
            
          }
        }
      
        ?>
      </table>
    </div>
  </body>
</html>