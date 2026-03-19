<?php
/**
 * NavStrike - Radar Display Template
 *
 * Displays radar contacts by sector.
 */
?>
<h2>Ecran Radar - Contacts</h2>
<form method="GET">
    <input type="hidden" name="page" value="radar">
    <select name="sector">
        <option value="all">Tous les secteurs</option>
        <option value="NORD">Nord</option>
        <option value="SUD">Sud</option>
        <option value="EST">Est</option>
        <option value="OUEST">Ouest</option>
    </select>
    <button type="submit">Scanner</button>
</form>

<?php if (isset($results) && $results && mysqli_num_rows($results) > 0): ?>
    <table border="1">
        <tr>
            <th>Contact</th>
            <th>Secteur</th>
            <th>Distance (nm)</th>
            <th>Cap</th>
            <th>Vitesse (kts)</th>
            <th>Classification</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)): ?>
            <tr>
                <td><?php echo $row['contact_id']; ?></td>
                <td><?php echo $row['sector']; ?></td>
                <td><?php echo $row['distance']; ?></td>
                <td><?php echo $row['heading']; ?></td>
                <td><?php echo $row['speed']; ?></td>
                <td><?php echo $row['classification']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Aucun contact radar dans ce secteur.</p>
<?php endif; ?>

<h3>Capteur distant</h3>
<form method="GET">
    <input type="hidden" name="page" value="radar-remote">
    <input type="text" name="sensor_url" placeholder="URL du capteur allie">
    <button type="submit">Interroger</button>
</form>
