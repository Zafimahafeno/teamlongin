<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des tâches</title>
  <style>
    .alert-container {
      position: absolute;
      top: 50px; /* Ajustez la position verticale selon vos préférences */
      left: 50%;
      transform: translateX(-50%);
      width: 300px; /* Largeur de l'alerte */
      color: #333;
      
      border-radius: 5px;
      padding: 10px;
      text-align: center;
      font-size: 14px; /* Taille de la police */
      z-index: 1;
    }
    .task-container {
      display: flex;
      justify-content: space-between;
      width: 100%;
    }

    .task-column {
  flex: 1;
  padding: 0 10px;
  transition: transform 1.5s ease-in-out;
}

.task-column h2 {
  text-align: center;
  transition: transform 1.5s ease-in-out;
}

.task {
  margin-bottom: 10px;
  border-radius: 5px;
  padding: 10px;
  position: relative;
  background: rgba(250, 250, 250, 0.3);
  border: 1px solid #ccc; /* Bordure ajoutée */
  transition: transform 0.1s ease-in-out, opacity 0.9s ease-in-out; /* Ajout de transition pour opacity */
  opacity: 1;
}
.task.fade-out {
  opacity: 0; /* Opacité réduite lors de la transition de fondu */
}

    .task h3 {
      margin-top: 0;
    }

    .task p {
      margin: 5px 0;
    }

    .finish-btn {
      display: none;
      position: absolute;
      top: 5px;
      right: 5px;
      background-color: red;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 3px;
      cursor: pointer;
    }

    .task:hover .finish-btn {
      display: inline-block;
    }

    .glass-morphism {
      background: rgba(0, 128, 0, 0.3);
      border-radius: 10px;
      backdrop-filter: blur(10px);
      padding: 10px;
      margin-bottom: 20px;
    }

    /* Drapeau de priorité */
    .priority-flag {
      position: absolute;
      bottom: 5px;
      right: 5px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 2px solid #000;
    }

    .moyen-flag {
      background-color: #5cb85c; /* Vert */
    }

    .elevee-flag {
      background-color: #f0ad4e; /* Orange */
    }

    .urgent-flag {
      background-color: #d9534f; /* Rouge */
    }

    /* Effet de clignotement */
    @keyframes blink {
      0% {
        box-shadow: 0 0 5px yellow;
      }
      50% {
        box-shadow: 0 0 10px red;
      }
      100% {
        box-shadow: 0 0 5px #5cb85c;
      }
    }

    .blink {
      animation: blink 3s;
    }
    .legend {
  margin-top: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  text-align: center;
}

.legend-item {
  display: inline-block;
  margin-right: 20px;
}

.priority-flag {
  display: inline-block;
  width: 20px;
  height: 20px;
  margin-right: 5px;
}

  </style>
</head>
<body>
  <?php include './includes/header.php'; ?>
  <?php include './includes/sidebar.php'; ?>

  <div class="alert-container"></div>

  <div class="modal" id="myModal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <p id="modalText"></p>
      <button id="modalOkButton" class="btn btn-primary">OK</button>
    </div>
  </div>

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Gestion de Tâche
        <small>Liste des tâches</small>
        <a href="add_tache.php" class="btn btn-primary">Enregistrer une nouvelle tâche</a>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Accueil</a></li>
        <li class="active">Liste des tâches</li>
      </ol>
    </section>

    <section class="content container-fluid">
      <div class="task-container">
        <div class="task-column">
          <div class="glass-morphism">
            <h2>Tâches</h2>
          </div>
          <div class="task-list" id="en-attente"></div>
        </div>
        <div class="task-column">
          <div class="glass-morphism">
            <h2>En cours</h2>
          </div>
          <div class="task-list" id="en-cours">
             </div>
        </div>
        <div class="task-column">
          <div class="glass-morphism">
            <h2>Validation</h2>
          </div>
          <div class="task-list" id="validation">
             </div>
        </div>
        <div class="task-column">
          <div class="glass-morphism">
            <h2>Terminées</h2>
          </div>
          <div class="task-list" id="terminees">
             </div>
        </div>
      </div>
    </section>
  </div>

  <?php include 'footer.php'; ?>

  <script>
  var enAttenteSection = document.getElementById('en-attente');
  var enCoursSection = document.getElementById('en-cours');
  var validationSection = document.getElementById('validation');
  var termineesSection = document.getElementById('terminees');

  function getTasks() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend/tache_backend.php', true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.tasks) {
            displayTasks(response.tasks);
          } else {
            console.error('Erreur lors de la récupération des tâches : ' + xhr.status);
          }
        }
      }
    };
    xhr.send();
  }

  function displayTasks(tasks) {
    enAttenteSection.innerHTML = '';
    enCoursSection.innerHTML = '';
    validationSection.innerHTML = '';
    termineesSection.innerHTML = '';

    var enAttenteTasks = tasks.filter(task => task.status === 'En attente');
    var enCoursTasks = tasks.filter(task => task.status === 'En cours');
    var validationTasks = tasks.filter(task => task.status === 'Validation');
    var termineesTasks = tasks.filter(task => task.status === 'Terminée');

    enAttenteTasks.forEach(task => displayTask(task, enAttenteSection, 'Commencer'));
    enCoursTasks.forEach(task => displayTask(task, enCoursSection, 'Valider'));
    validationTasks.forEach(task => displayTask(task, validationSection, 'Terminer'));
    termineesTasks.forEach(task => displayTask(task, termineesSection, 'Terminer'));
    addEventListenersToButtons();
  }

  function displayTask(task, section, buttonText) {
    var taskHTML = '<div class="task blink">';
    taskHTML += '<h3>' + task.titre + '</h3>';
    taskHTML += '<p>Description: ' + task.description + '</p>';
    taskHTML += '<p>Echéance : ' + task.echeance + '</p>';
    taskHTML += '<p>Priorité : ' + task.priorite + '</p>';
    taskHTML += '<p>Responsable : ' + task.responsable + '</p>';
    taskHTML += '<p>Status : ' + task.status + '</p>';
    taskHTML += '<p>Lieu : ' + task.lieu + '</p>';
    taskHTML += '<button class="finish-btn" data-task-id="' + task.id + '" data-current-status="' + task.status + '">' + buttonText + '</button>';

    taskHTML += '<div class="priority-flag ';
    if (task.priorite === 'Moyen') {
      taskHTML += 'moyen-flag';
    } else if (task.priorite === 'Élevée') {
      taskHTML += 'elevee-flag';
    } else if (task.priorite === 'Urgent') {
      taskHTML += 'urgent-flag';
    }
    taskHTML += '"></div>';
    taskHTML += '</div>';
// Ajoute la classe "blink" uniquement à la tâche affichée, pas à toutes les tâches
if (task.updated) {
    taskHTML += '<div class="blink"></div>'; // Ajoute la classe "blink" uniquement à la tâche mise à jour
    task.updated = false; // Réinitialise le drapeau "updated"
  }

  section.innerHTML += taskHTML;
  }

  function addEventListenersToButtons() {// Select all buttons with the class "finish-btn"
    var finishButtons = document.querySelectorAll('.finish-btn');

    // Loop through all buttons and add a click event listener to each
    finishButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
        var taskId = parseInt(event.target.dataset.taskId);
        var currentStatus = event.target.dataset.currentStatus;

        // Add animation class for smooth transition before removing the task
        var task = event.target.parentElement;
        task.classList.add('fade-out');

        // Set a timeout to simulate the update process and remove the task after animation
        setTimeout(function() {
          finishTask(taskId, currentStatus);
          task.remove();
        }, 300); // Adjust timeout duration as needed (in milliseconds)
      });
    });
  }

  function finishTask(taskId, currentStatus) {
  // Remove blink class from the task being updated before sending request
  var taskToUpdate = document.querySelector('[data-task-id="' + taskId + '"]');
  taskToUpdate.classList.remove('blink');

  // Send AJAX request to update task status
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'backend/update_status.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Get updated tasks and redisplay them
        getTasks();

        // Find the updated task and add blink class back
        var updatedTask = document.querySelector('[data-task-id="' + taskId + '"]');
    updatedTask.dataset.updated = true; // Supprimer la classe blink avant de la rajouter

    updatedTask.classList.add('blink');

        // Optionally, remove blink class after a timeout (e.g., 3 seconds)
        setTimeout(function() {
          updatedTask.classList.remove('blink');
        }, 1000);

        // Display success alert based on updated status
        if (currentStatus === 'En attente') {
          showAlert('Votre tâche commence maintenant', 'alert-success');
        } else if (currentStatus === 'En cours') {
          showAlert('Votre tâche a été envoyée pour validation au responsable', 'alert-success');
        }
      } else {
        console.error('Erreur lors de la mise à jour du statut de la tâche : ' + xhr.status);
        showAlert('Erreur lors de la mise à jour du statut de la tâche. Veuillez réessayer.', 'alert-error');
      }
    }
  };

  // Send the action (start, validate, complete) based on current status
  if (currentStatus === 'En attente') {
    xhr.send('taskId=' + taskId + '&action=start');
  } else if (currentStatus === 'En cours') {
    xhr.send('taskId=' + taskId + '&action=validate');
  } else if (currentStatus === 'Validation') {
    xhr.send('taskId=' + taskId + '&action=complete');
  }
}





// Fonction pour afficher l'alerte avec le message et la classe CSS spécifiés
function showAlert(message, alertClass) {
    var alertElement = document.createElement('div');
    alertElement.textContent = message;
    alertElement.className = 'alert ' + alertClass;
    var alertContainer = document.querySelector('.alert-container');
    alertContainer.appendChild(alertElement);
    // Supprimer l'alerte après quelques secondes
    setTimeout(function() {
        alertElement.remove();
    }, 1000); // 5000 millisecondes = 5 secondes
}



  window.onload = function() {
    getTasks();
  };

  </script>
</body>
</html>
