<?php
/**
 * NavStrike - Crew Management Template
 *
 * Displays crew assignments at combat stations.
 */
?>
<h2>Equipage - Postes de Combat</h2>

<?php if (isset($results) && $results && mysqli_num_rows($results) > 0): ?>
    <table border="1">
        <tr>
            <th>Grade</th>
            <th>Nom</th>
            <th>Role</th>
            <th>Poste</th>
            <th>Habilitation</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)): ?>
            <tr>
                <td><?php echo $row['rank']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td><?php echo $row['station']; ?></td>
                <td><?php echo $row['clearance']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Aucun equipage affecte aux postes de combat.</p>
<?php endif; ?>

<h3>Recherche par role</h3>
<form method="GET">
    <input type="hidden" name="page" value="crew">
    <select name="role">
        <option value="OTD">Officier de Tir et Direction</option>
        <option value="ORD">Operateur Radar</option>
        <option value="OGM">Operateur Guerre des Mines</option>
        <option value="TIM">Timonier</option>
        <option value="MEC">Mecanicien</option>
    </select>
    <button type="submit">Filtrer</button>
</form>
