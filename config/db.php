<?php
// Connexion à la base de données - Remplacez les valeurs par les vôtres
  $servername = "mysql-mahafeno.alwaysdata.net"; //mysql-mahafeno.alwaysdata.net
  $username = "mahafeno"; //mahafeno
  $password = "antso0201"; ///antso0201
  $dbname = "mahafeno_longin";

  // Création de la connexion
  $conn = new mysqli($servername, $username, $password, $dbname);
  // echo 'Connexion à la base de données établie :)';
  // Vérification de la connexion
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }