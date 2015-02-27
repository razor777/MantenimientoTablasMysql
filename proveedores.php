
<?php
  $registros = array();
  
   $lasInsertID=0;
  
     //Realizar la conexion con MySQL
    $conn = new mysqli("127.0.0.1", "root", "", "new201501");
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
     $lasInsertID= $conn->insert_id;
   
 
  }
    
 
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
    <form action="proveedores.php" method="POST">
        <label for="prvdsc">Descripción</label>
        <input type="text" name="prvdsc" id="prvdsc" />
        <br/>
        <label for="prvemail">Email</label>
        <input type="email" name="prvemail" id="prvemail" />
        <br/>
        <label for="prvtel">Telefono</label>
        <input type="text" name="prvtel" id="prvtel" />
        <br/>
        <label for="prvcont">Contacto</label>
        <input type="text" name="prvcont" id="prvcont" />
        <br/>
        <label for="prvdir">Direccion</label>
        <input type="text" name="prvdir" id="prvdir" />
        <br/>
        <label for="prvest">Estado</label>
        <select name="prvest" id="prvest">
            <option value="PND">Pendiente</option>
            <option value="CNF">Confirmado</option>
            <option value="CNL">Cancelado</option>
        </select>
        <br/>
        <input type="submit" name="btnIns" value="Guardar" />
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

