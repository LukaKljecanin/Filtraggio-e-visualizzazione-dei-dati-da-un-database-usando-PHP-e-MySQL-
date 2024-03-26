<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <?php
    // print_r($_GET);
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "nuovo_dataBase";
    $conn = new mysqli($servername, $username, $password, $database);
    $sql = "SELECT * FROM `ruolo`";
    $result = $conn->query($sql);?>


  <div id="filters" class="container mt-5">
    <form method="GET">
      <div class="mb-3">
        <label for="Ruolo" class="form-label">Ruolo:</label>
        <select name="ruolo_id" class="form-select">
          <option value="">Seleziona ruolo</option>
          <?php
              while ($row = $result->fetch_assoc()) {
                  if(isset($_GET["ruolo_id"]) && $row["id_ruolo"] == $_GET["ruolo_id"]) {
                  ?>
          <option value=<?php echo $row["id_ruolo"] ?> selected><?php echo $row["id_ruolo"]?></option>
          <?php
                  }else {
                    ?>
          <option value=<?php echo $row["id_ruolo"] ?>><?php echo $row["id_ruolo"]?></option>
          <?php
                  }
              } 
            ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="Reparti" class="form-label">Reparti:</label>
        <select name="reparto_id" class="form-select">
          <option value="">Seleziona reparto</option>
          <?php
              $sqlR = "SELECT * FROM `reparti`";
              $resultR = $conn->query($sqlR);
              while ($row = $resultR->fetch_assoc()) {
                  if(isset($_GET["reparto_id"]) && $row["ID"] == $_GET["reparto_id"]) {
                  ?>
          <option value=<?php echo $row["ID"] ?> selected><?php echo $row["ID"]?></option>
          <?php
                  }else {
                    ?>
          <option value=<?php echo $row["ID"] ?>><?php echo $row["ID"]?></option>
          <?php
                  }
              } 
            ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Cerca</button>
    </form>
    <h4 class='container mt-5'>Consultazione del personale</h4>
  </div>
  <?php
      if(empty($_GET)) {
        //TABELLA QUANDO ENTRO NEL FILE
        
        $anagrafe = "SELECT * FROM `anagrafica`";

        $risultatoTabella = $conn ->query($anagrafe);

        $getTable = setTable($risultatoTabella);
        // echo "<h4 class = 'container mt-5'>Consultazione del personale</h4>";
        echo $getTable;
      }else if($_GET["ruolo_id"] !== "" && $_GET["reparto_id"] !== ""){
        //TABELLA RUOLI
        $ruolo = $_GET["ruolo_id"];

        $reparti = $_GET["reparto_id"];
        
        $anagrafe = "SELECT * FROM `anagrafica` WHERE `id_ruolo` = $ruolo AND `id_reparti` = $reparti";
        
        $risultatoTabella = $conn ->query($anagrafe);
      
        $getTable = setTable($risultatoTabella);
        echo $getTable;
      } else if ($_GET["ruolo_id"] !== "" && $_GET["reparto_id"] == "" ) {

        $ruolo1 = $_GET["ruolo_id"];

        // echo("sono qua in ruoli");
        $anagrafe = "SELECT * FROM `anagrafica` WHERE `id_ruolo` = $ruolo1";
  
        $risultatoTabellaRuoli = $conn ->query($anagrafe);

        $getTable = setTable($risultatoTabellaRuoli);
        echo $getTable;
      }  else if ($_GET["ruolo_id"] == "" && $_GET["reparto_id"] !== "") {
        //TABELLA REPARTI
        $reparto = $_GET["reparto_id"];
        // echo("<br>");
        // echo("sono qua in reparti");
        
        $anagrafe = "SELECT * FROM `anagrafica` WHERE `id_ruolo` = $reparto";
  
        $risultatoTabellaReparti = $conn ->query($anagrafe);

        $getTable = setTable($risultatoTabellaReparti);
        echo $getTable;
      } else if ($_GET["ruolo_id"] == "" && $_GET["reparto_id"] == "") {

        $anagrafe = "SELECT * FROM `anagrafica`";

        $risultatoTabella = $conn ->query($anagrafe);

        $getTable = setTable($risultatoTabella);

        echo $getTable;

      }
      
      //FUNZIONE TABELLA
      function setTable($result) {
        $table = '<div class="container mt-5">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Cognome</th>
                                <th>Anno di assunzione</th>
                            </tr>
                        </thead>
                        <tbody>';
                        
        while ($row = $result->fetch_assoc()) {
          // echo("<br>");
          // print_r($row);
          $table .= '<tr>
                      <td>' . $row["nome"] . '</td>
                      <td>' . $row["cognome"] . '</td>
                      <td>' . $row["anno_assunzione"] . '</td>
                    </tr>';
        }
      
        $table .= '</tbody></table></div>';
      
        return $table;
      }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>