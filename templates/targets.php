<?php
/**
 * NavStrike - Target Tracking Template
 *
 * Displays target search form and tracking results.
 */
?>
<h2>Suivi des Cibles Hostiles</h2>
<form method="GET" action="?page=search-targets">
    <input type="hidden" name="page" value="search-targets">
    <input type="text" name="q" placeholder="Designation ou zone">
    <button type="submit">Rechercher</button>
</form>

<?php if (isset($_GET['q'])): ?>
    <h3>Resultats pour : <?php echo $_GET['q']; ?></h3>
<?php endif; ?>

<?php if (isset($results) && $results && mysqli_num_rows($results) > 0): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Designation</th>
            <th>Type</th>
            <th>Position</th>
            <th>Niveau Menace</th>
            <th>Statut</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['designation']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['latitude']; ?>, <?php echo $row['longitude']; ?></td>
                <td><?php echo $row['threat_level']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Aucune cible detectee dans ce secteur.</p>
<?php endif; ?>

<h3>Ajouter une cible</h3>
<form method="POST" action="?page=add-target">
    <input type="text" name="designation" placeholder="Designation (ex: TANGO-01)">
    <select name="type">
        <option value="surface">Batiment de surface</option>
        <option value="submarine">Sous-marin</option>
        <option value="aircraft">Aeronef</option>
        <option value="land">Objectif terrestre</option>
    </select>
    <input type="text" name="latitude" placeholder="Latitude">
    <input type="text" name="longitude" placeholder="Longitude">
    <select name="threat_level">
        <option value="CRITICAL">CRITIQUE</option>
        <option value="HIGH">ELEVE</option>
        <option value="MEDIUM">MOYEN</option>
        <option value="LOW">FAIBLE</option>
    </select>
    <button type="submit">Ajouter au tracking</button>
</form>
