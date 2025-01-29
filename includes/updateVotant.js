// Function to make a cell editable
function makeEditable(cell, originalContent, fieldName) {
  let input;

  // Créer un select pour les champs spéciaux
  if (fieldName === "id_etablissement" || fieldName === "id_candidat") {
    input = document.createElement("select");
    input.className = "form-control input-sm";
    input.name = fieldName;

    // Les options seront chargées via une fonction séparée
    loadSelectOptions(input, fieldName, originalContent);
  } else if (fieldName === "intentionVote") {
    input = document.createElement("select");
    input.className = "form-control input-sm";
    input.name = fieldName;

    // Options pour intention de vote
    const options = ["Favorable", "Opposant", "Indecis"];
    options.forEach((option) => {
      const opt = document.createElement("option");
      opt.value = option;
      opt.textContent = option;
      if (option === originalContent) opt.selected = true;
      input.appendChild(opt);
    });
  } else if (fieldName === "DernierContact") {
    input = document.createElement("input");
    input.type = "date";
    input.value = originalContent;
    input.className = "form-control input-sm";
    input.name = fieldName;
  } else {
    input = document.createElement("input");
    input.type = "text";
    input.value = originalContent;
    input.className = "form-control input-sm";
    input.name = fieldName;
  }

  // Replace cell content with input
  cell.innerHTML = "";
  cell.appendChild(input);

  return input;
}

// Function to load select options
async function loadSelectOptions(select, fieldType, currentValue) {
  try {
    const response = await fetch(`./backend/get_options.php?type=${fieldType}`);
    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
    const data = await response.json();

    // Add empty option for etablissement
    if (fieldType === "id_etablissement") {
      const emptyOption = document.createElement("option");
      emptyOption.value = "";
      emptyOption.textContent = "Aucun établissement";
      select.appendChild(emptyOption);
    }

    data.forEach((item) => {
      const option = document.createElement("option");
      option.value = item.id;

      // Format differently for candidat
      if (fieldType === "id_candidat") {
        option.textContent = `${item.numero} - ${item.prenom} ${item.nom}`;
      } else {
        option.textContent = item.nom;
      }

      // Select current value
      if (
        item.nom === currentValue ||
        `${item.numero} - ${item.prenom} ${item.nom}` === currentValue
      ) {
        option.selected = true;
      }

      select.appendChild(option);
    });
  } catch (error) {
    console.error("Erreur lors du chargement des options:", error);
    showNotification("Erreur lors du chargement des options", "error");
  }
}

// Function to load select options
async function loadSelectOptions(select, fieldType) {
  try {
    const response = await fetch(`./backend/get_options.php?type=${fieldType}`);
    const data = await response.json();

    data.forEach((item) => {
      const option = document.createElement("option");
      option.value = item.id;
      option.textContent = item.nom || item.name;
      select.appendChild(option);
    });
  } catch (error) {
    console.error("Erreur lors du chargement des options:", error);
  }
}

// Function to save changes

async function saveChanges(rowId, updatedData) {
  try {
    const response = await fetch("./backend/update_votant.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        id: rowId,
        ...updatedData,
      }),
    });

    if (!response.ok) throw new Error("Erreur lors de la sauvegarde");

    const result = await response.json();
    if (result.success) {
      showNotification("Modifications enregistrées avec succès", "success");
      // Recharger la page après 1 seconde
      setTimeout(() => {
        window.location.reload();
      }, 1000);
    } else {
      showNotification(
        result.message || "Erreur lors de la sauvegarde",
        "error"
      );
    }

    return result;
  } catch (error) {
    console.error("Erreur:", error);
    showNotification("Erreur lors de la sauvegarde des modifications", "error");
    return { success: false };
  }
}

// Function to handle edit mode
function enableEditMode(row) {
  const rowId = row.cells[0].textContent;

  // Store original content and inputs
  const originalContent = {};
  const inputs = {};

  // Fields to make editable (including new fields)
  const editableFields = [
    "nom_votant",
    "prenom",
    "fonction",
    "email",
    "tel",
    "intentionVote",
    "DernierContact",
    "commentaire",
    "demarcheEffectue",
    "proposition",
    "id_etablissement",
    "id_candidat",
  ];

  // Make cells editable
  editableFields.forEach((field, index) => {
    const cell = row.querySelector(`[data-field="${field}"]`);
    if (cell) {
      originalContent[field] = cell.textContent;
      inputs[field] = makeEditable(cell, originalContent[field], field);
    }
  });

  // Create save and cancel buttons
  const actionCell = row.querySelector(".action-col");
  const originalActions = actionCell.innerHTML;

  actionCell.innerHTML = `
        <button class="btn btn-success btn-xs save-btn" title="Enregistrer">
            <i class="fa fa-check"></i>
        </button>
        <button class="btn btn-danger btn-xs cancel-btn" title="Annuler">
            <i class="fa fa-times"></i>
        </button>
    `;

  // Add event listeners for save and cancel
  actionCell.querySelector(".save-btn").addEventListener("click", async () => {
    const updatedData = {};
    editableFields.forEach((field) => {
      if (inputs[field]) {
        updatedData[field] = inputs[field].value;
      }
    });

    const result = await saveChanges(rowId, updatedData);
    if (result.success) {
      // Update cells with new values
      editableFields.forEach((field) => {
        if (inputs[field]) {
          const cell = inputs[field].parentElement;
          cell.textContent = inputs[field].options
            ? inputs[field].options[inputs[field].selectedIndex].text
            : inputs[field].value;
        }
      });
      actionCell.innerHTML = originalActions;
    }
  });

  actionCell.querySelector(".cancel-btn").addEventListener("click", () => {
    editableFields.forEach((field) => {
      if (inputs[field]) {
        const cell = inputs[field].parentElement;
        cell.textContent = originalContent[field];
      }
    });
    actionCell.innerHTML = originalActions;
  });
}

// Notification function
function showNotification(message, type) {
  const notification = document.createElement("div");
  notification.className = `alert alert-${
    type === "success" ? "success" : "danger"
  } notification`;
  notification.style.position = "fixed";
  notification.style.top = "40px";
  notification.style.right = "20px";
  notification.style.zIndex = "1000000";
  notification.textContent = message;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.remove();
  }, 3000);
}

// Initialize edit buttons
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".fa-edit").forEach((editIcon) => {
    editIcon.closest("a").addEventListener("click", (e) => {
      e.preventDefault();
      const row = editIcon.closest("tr");
      enableEditMode(row);
    });
  });
});
