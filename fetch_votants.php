<?php
$servername = "mysql-mahafeno.alwaysdata.net";
$username = "mahafeno";
$password = "antso0201";
$dbname = "mahafeno_longin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_POST['search']) ? "%" . $_POST['search'] . "%" : "%";

$sql = "SELECT v.id, v.nom_votant, v.prenom, v.fonction, v.intentionVote, v.DernierContact, e.nom 
        FROM votant v 
        JOIN etablissement e ON v.id_etablissement = e.id_etablissement 
        WHERE v.fonction = 'Enseignant' 
        AND (v.nom_votant LIKE ? OR v.prenom LIKE ? OR v.fonction LIKE ? OR e.nom LIKE ? OR v.intentionVote LIKE ? OR v.DernierContact LIKE ?)
        ORDER BY v.nom_votant";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $search, $search, $search, $search, $search, $search);
$stmt->execute();
$result = $stmt->get_result();

$output = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= "<tr id='row-" . $row['id'] . "'>";
        $output .= "<td>" . htmlspecialchars($row['nom_votant']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['prenom']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['fonction']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['nom']) . "</td>";
        $output .= "<td>
                    <select id='vote-" . $row['id'] . "' onchange='updateVote(" . $row['id'] . ", this.value)' class='form-select'>
                        <option value='favorable'" . ($row['intentionVote'] == 'favorable' ? ' selected' : '') . ">Favorable</option>
                        <option value='opposant'" . ($row['intentionVote'] == 'opposant' ? ' selected' : '') . ">Opposant</option>
                        <option value='indécis'" . ($row['intentionVote'] == 'indécis' ? ' selected' : '') . ">Indécis</option>
                    </select>
                </td>";
        $output .= "<td>
                    <input type='date' id='date-" . $row['id'] . "' value='" . htmlspecialchars($row['DernierContact']) . "' 
                    onchange='updateDate(" . $row['id'] . ", this.value)' class='form-control'>
                </td>";
        $output .= "<td>
                    <button class='btn btn-success btn-sm' onclick='modifierVotant(" . $row['id'] . ")'>
                        <i class='bi bi-pencil'></i>
                    </button>
                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirmModal' onclick='setDeleteId(" . $row['id'] . ")'>
                        <i class='bi bi-trash'></i>
                    </button>
                </td>";
        $output .= "</tr>";
    }
} else {
    $output .= "<tr><td colspan='7'>Aucun votant trouvé.</td></tr>";
}

$stmt->close();
$conn->close();
echo $output;
?>
