<?php
  $registros = array();
   $lasInsertID="";
   
     //Realizar la conexion con MySQL
  $conn = new mysqli("127.0.0.1", "root", "", "new201501");
    if($conn->errno){
      die("DB no can: " . $conn->error);
    }
   
  if(isset($_POST["btnIns"])){
    $registro = array();
    $registro["descripcion"] = $_POST["prddsc"];
    $registro["brc"] = $_POST["prdbrc"];
    $registro["cant"] = $_POST["prdctd"];
    $registro["estado"] = $_POST["prdest"];
    $registro["categoria"] = $_POST["ctgid"];
  
    //Preparar el Insert Statement
    $sqlinsert ="INSERT INTO `productos` ( `prddsc`, `prdbrc`, `prdctd`, `prdest`, `ctgid`)";
    $sqlinsert.="VALUES ('". $registro["descripcion"] ."' , '". $registro["brc"] ."' , '". $registro["cant"] ."' , '". $registro["estado"] ."' , '". $registro["categoria"] ."');";
    //Ejecutar el Insert Statement
    $result = $conn->query($sqlinsert);
    //Obtener el último codigo generado
    $lasInsertID= $conn->insert_id;
  }
    
    
    
    $sqlQuery="Select * from productos;";
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
    <title>Formulario de Productos</title>
  </head>
  <body>
    <h1>Productos</h1>
    <form action="productos.php" method="POST">
        <label for="prddsc">Descripción</label>
        <input type="text" name="prddsc" id="prddsc"/>
        <br/>
        <label for="prdbrc">Brc</label>
        <input type="text" name="prdbrc" id="prdbrc"  />
        <br/>
        <label for="prdctd">Cantidad</label>
        <input type="text" name="prdctd" id="prdctd" />
        <br/>
        <label for="prdest">Estado</label>
        <select name="prdest" id="prdest" />
            <option value="PND">Pendiente</option>
            <option value="CNF">Confirmado</option>
            <option value="CNL">Cancelado</option>
        </select>
        <br/>
        <label for="ctgid">CategoriaId</label>
        <input type="text" name="ctgid" id="ctgid" />
        <br/>
        <input type="submit" name="btnIns" value="Guardar" />
        <br/>
        
    </form>
    <div>
      <h2>Datos</h2>
      
      <table>
        <tr>
          <th>Codigo</th>
          <th>Descripción</th>
          <th>Brc</th>
          <th>Cantidad</th>
          <th>Estado</th>
          <th>CategoriaID</th>
        </tr>
        <?php
        if(count($registros)>0){
          foreach($registros as $registro){
              
              echo "<tr><td>".$registro["prdid"]."</td>";
              echo "<td>".$registro["prddsc"]."</td>";
              echo "<td>".$registro["prdbrc"]."</td>";
              echo "<td>".$registro["prdctd"]."</td>";
              echo "<td>".$registro["prdest"]."</td>";
              echo "<td>".$registro["ctgid"]."</td></tr>";
            
          }
        }
      
        ?>
      </table>
       <?php echo "Last Saved Id =  $lasInsertID"?>
    </div>
  </body>
</html>