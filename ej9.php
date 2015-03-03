<?php
  require_once("ado.php");
  require_once("utilities.php");
  $producto = array(
   "prdid" => 0,
   "prddsc" =>"",
   "prdbrc" =>"",
   "prdctd" =>0,
   "prdest" =>"ACT",
   "ctgid " =>0
  );
  $categorias = array();
  $categorias = obtenerRegistros("select * from categorias where ctgest='ACT';");
  $mode = "noset";
  $modeDescription = array(
    "insert" => "Nuevo Producto",
    "update" => "Actualizar Producto",
    "delete" => "Borrar Producto"
  );
  if(isset($_GET["action"])){
    switch($_GET["action"]){
      case "new":
        $mode= "insert";
        if(isset($_POST["btnInsert"])){
          $sqlinsert = "INSERT INTO `productos` (`prddsc`,`prdbrc`,`prdctd`,`prdest`,`ctgid`) VALUES ('%s','%s',%d,'%s', %d);";
          $sqlinsert = sprintf($sqlinsert,
                              $_POST["prddsc"],
                              $_POST["prdbrc"],
                              intval($_POST["prdctd"]),
                              $_POST["prdest"],
                              intval($_POST["ctgid"])
                              );
          insertRegistro($sqlinsert);
          redirectWithMessage('Registro guardado con exito!', 'ej8.php');
        }
        break;
      case "upd":
        if(isset($_POST["btnInsert"])){
          if(isset($_POST["prdid"])){
            $strupdate = "UPDATE `productos` SET `prddsc` = '%s', `prdbrc` = '%s', `prdctd` =%d, `prdest` = '%s', `ctgid` = %d WHERE `prdid` = %d;";
            $strupdate = sprintf($strupdate,
                                $_POST["prddsc"],
                                $_POST["prdbrc"],
                                intval($_POST["prdctd"]),
                                $_POST["prdest"],
                                intval($_POST["ctgid"]),
                                intval($_POST["prdid"])
                                );
            updateRegistro($strupdate);
            redirectWithMessage('Producto Actualizado!', 'ej8.php?action=upd&prdid='.$_POST["prdid"]);
          }
        }
        $mode= "update";
        $strsql = "select * from productos where prdid = %d;";
        $strsql = sprintf($strsql,$_GET["prdid"]);
        $producto = obtenerUnRegistro($strsql);
        if($producto){
          $modeDescription[$mode] .= " " . $_GET["prdid"] . " " . $producto["prddsc"];
        }else{
          redirectWithMessage('EL producto no existe!', 'ej8.php');
        }
        break;
      case "del":
       
        if(isset($_POST["btnInsert"])){
          if(isset($_POST["prdid"])){
             
        $strdel = "DELETE FROM `productos` WHERE `prdid`=%d;";
         $strdel = sprintf($strdel,$_POST["prdid"]);
        DeleteRegistro($strdel);
         redirectWithMessage('Producto Eliminado!', 'ej8.php?action=del&prdid='.$_POST["prdid"]);
          }
        }
         $mode = "delete";
        $strsql = "select * from productos where prdid = %d;";
        $strsql = sprintf($strsql,$_GET["prdid"]);
        $producto = obtenerUnRegistro($strsql);
         if($producto){
          $modeDescription[$mode] .= " " . $_GET["prdid"] . " " . $producto["prddsc"];
        }else{
          redirectWithMessage('EL producto no existe!', 'ej8.php');
        }
        
        break;
      default:
        //truquito muy util.
        redirectWithMessage('No Tiene Acceso a Esta página, redirigiendo.', 'ej8.php');
    }
  }else{
    // ESTO ES ULTRA IMPORTANTE
    // PARA REDIRIGIR A OTRA PAGINA
    // DESDE PHP
    header("location:ej8.php");
    die();
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title></title>
  </head>
  <body>
    <h1><?php echo $modeDescription[$mode]; ?></h1>
    <form action="ej9.php?action=<?php echo $_GET["action"]; ?>" method="POST">
        <?php
         ?>
         <label for="prdid">
           Código Producto
         </label>
         <input type="hidden" value="<?php echo $producto["prdid"]; ?>"
                name="prdid" id="prdid" />

         <br/>
         <label for="prddsc">
           Producto
         </label>
         <input type="text" value="<?php echo $producto["prddsc"]; ?>"
                name="prddsc" id="prddsc" <?php if($mode=="delete") echo 'disabled="disabled"'; ?>/>
         <br/>
         <label for="prdbrc">
           Código de Barra<br/><i>EAN32, QR, CODE 189</i>
         </label>
         <input type="text" value="<?php echo $producto["prdbrc"]; ?>"
                name="prdbrc" id="prdbrc" <?php if($mode=="delete") echo 'disabled="disabled"'; ?> />
         <br/>

         <label for="prdctd">
           Cantidad
         </label>
         <input type="number" value="<?php echo $producto["prdctd"]; ?>"
                name="prdctd" id="prdctd" <?php if($mode=="delete") echo 'disabled="disabled"'; ?> />
         <br/>

         <label for="prdest">
           Estado
         </label>
         <select id="prdest" name="prdest" <?php if($mode=="delete") echo 'disabled="disabled"'; ?>>
           <option value="ACT" <?php echo ($producto["prdest"]=="ACT")?"selected":""; ?> >Activo</option>
           <option value="INA" <?php echo ($producto["prdest"]=="INA")?"selected":""; ?>>Inactivo</option>
           <option value="DES" <?php echo ($producto["prdest"]=="DES")?"selected":""; ?>>Descontinuado</option>
           <option value="RET"<?php echo ($producto["prdest"]=="RET")?"selected":""; ?>>Retirado</option>
         </select>
         <br/>
        <label for="ctgid"> Categoría</label>
         <select id="ctgid" name="ctgid" <?php if($mode=="delete") echo 'disabled="disabled"'; ?>>
           <?php
              foreach($categorias as $categoria){
                echo '<option value="'.$categoria["ctgid"].'">'.$categoria["ctgdsc"].'</option>';
              }
           ?>
         </select>
         <br/>
         <input type="submit" name="btnInsert" id="btnInsert" value="Guardar" />
    </form>
  </body>
</html>