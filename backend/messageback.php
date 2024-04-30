<?php
// backend.php

// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupère les données du formulaire
  $data = json_decode(file_get_contents('php://input'), true);

  // Construit l'URL de l'API Sinch
  $url = 'https://sms.api.sinch.com/xms/v1/' . 9430908b3809486096b44c184b5192bf . '/batches';

  // En-têtes de la demande
  $headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . a7591a9b549e4b99941ccf34e557242d
  );

  // Options de la demande
  $options = array(
    'http' => array(
      'header' => $headers,
      'method' => 'POST',
      'content' => json_encode($data),
      'ignore_errors' => true // Ignorer les erreurs HTTP pour obtenir la réponse de Sinch même en cas d'erreur
    )
  );

  // Crée un flux de contexte pour la demande HTTP
  $context = stream_context_create($options);

  // Effectue la demande HTTP à l'API Sinch
  $response = file_get_contents($url, false, $context);

  // Vérifie si la réponse a été reçue
  if ($response === false) {
    // Erreur lors de l'envoi de la demande
    http_response_code(500); // Erreur de serveur interne
    echo json_encode(array("message" => "Erreur lors de l'envoi de la demande à l'API Sinch."));
  } else {
    // Décode la réponse JSON de l'API Sinch
    $sinchResponse = json_decode($response, true);

    // Vérifie si la requête a réussi
    if ($sinchResponse['status'] === 'success') {
      // Message envoyé avec succès
      $message = "Message envoyé avec succès! ID du message: " . $sinchResponse['id'];
    } else {
      // Erreur lors de l'envoi du message
      $message = "Erreur lors de l'envoi du message: " . $sinchResponse['message'];
    }

    // Affiche le message à l'utilisateur
    echo json_encode(array("message" => $message));
  }
}
