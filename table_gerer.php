 <!--
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Table Api webservice</title>
  este codigo viene directamente de  https://bootswatch.com/cerulean/ -->
 <!-- descarga bootstrap.min.css crea una carpeta css y pegalo dentro y dale la ruta aqui
  <link rel="stylesheet" href="./css/bootstrap.min.css" />
  <link rel="stylesheet" href="./css/bootstrap-icons-1.9.1/bootstrap-icons.css" />  
</head>

https://www.ma-conciergerie.techsysprogram.com/page-test
-->
 <?php
    require_once 'data/ws_table2.php';

    //echo $response;
    // @$check = $_POST["check"];
    // @$valider = $_POST["valider"];
    // if (isset($valider)) {
    //   echo "vous avez coché les case suivantes: <br />";
    //   echo @implode(" _ ", $check);
    //   echo "<hr />";
    // }
    ?>

 <body>
     <!-- <div class="container"> -->
     <table class="table table-hover">
         <thead>
             <tr class="table-active">
                 <th scope="col"></th>
                 <th scope="col">Planche2222</th>
                 <th scope="col">Numéro</th>
                 <th scope="col">Effacer</th>
             </tr>
         </thead>
         <tbody>

             <?php
                // $response aqui regreso los datos json del webservice
                $html2 = "";
                // $arr = json_decode('[{"var1":"9","var2":"16","var3":"16"},{"var1":"8","var2":"15","var3":"15"}]');

                $arr = json_decode($response, true);
                $etat = true;
                $PlancheNom = "";

                foreach ($arr as $item) { //foreach element in $arr
                    $etat = $item['bEtat'];
                    $Codebarre = $item['sCodeBarre'];
                    $PlancheNom = $item['sPlancheDescrip'] . " - " . $item['sPlancheType'];

                    //aqui separa la liena en 3 partes codebarre,actif!,number
                    $html2 = $html2 . ($etat ? "<tr class='table-success'>" : "<tr>");
                    if (!$etat) {
                        $html2 = $html2 . <<< FIN
						<th scope='row'>
						<div class="form-check">
						<input class="form-check-input" type="checkbox" name="check01" value=$Codebarre>
						<!-- este contenido sera remplazado con la action del clic -->
						<!-- <div id="answer2"></div> -->
						FIN;
                    } else {
                        $html2 = $html2 . "<th>";
                    }
                    $html2 = $html2 . "</th>";
                    $html2 = $html2 . "<td>$PlancheNom</td>";
                    if ($etat) {
                        $html2 = $html2 . "<td><a href='http://planches.techsysprogram.fr/LotoWS/PDFRecuperer/PL-$Codebarre.pdf' target='_blank'> <button class='btn btn-success' vertical-align:bottom><i class='bi-download'></i> $Codebarre</button> </a></td>";
                    } else {
                        $html2 = $html2 . "<td>$Codebarre</td>";
                    }
                    $html2 = $html2 . "<td><a href='http://planches.techsysprogram.fr/LotoWS/PDFRecuperer/PL-$Codebarre.pdf' target='_blank'> <button class='btn btn-danger' vertical-align:bottom>Supprimer <i class='bi-x'></i> </button> </a></td>";

                    $html2 = $html2 . "</tr>";
                }
                echo $html2;
                ?>

         </tbody>
     </table>


     <button class="btn btn-primary" name="valider2" id="btnGerer">Ache!</button>
     <div id="Gerer"></div>


     <!-- aqui codigo para los scripts -->
     <!-- importante para que los scripts funcionen 
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<!-- la verdad esta linea lo puse porque bootstrap lo pone por defecto no se si lo utiliso en verdad de 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> 
<script src= get_template_directory_uri() + "/inc/bootstrap/js/myscript.js"></script>
	
	<!--?php echo get_template_directory_uri() . "/inc/bootstrap/js/myscript.js";?>-->

 </body>