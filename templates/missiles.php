<?php
/**
 * NavStrike - Missile Inventory Template
 *
 * Displays missile inventory and launch controls.
 */
?>
<h2>Inventaire Missiles - Cellules VLS</h2>

<?php if (isset($results) && $results && mysqli_num_rows($results) > 0): ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Cellule VLS</th>
            <th>Statut</th>
            <th>Portee (km)</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['vls_cell']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['range_km']; ?></td>
                <td>
                    <?php if ($row['status'] === 'READY'): ?>
                        <form method="POST" action="?page=launch" style="display:inline;">
                            <input type="hidden" name="missile_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="status" value="ARMED">
                            <button type="submit">ARMER</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Inventaire missiles indisponible.</p>
<?php endif; ?>

<h3>Recherche par type</h3>
<form method="GET">
    <input type="hidden" name="page" value="missiles">
    <select name="type">
        <option value="Exocet MM40">Exocet MM40 Block 3</option>
        <option value="Aster-15">Aster-15</option>
        <option value="Aster-30">Aster-30</option>
        <option value="SCALP Naval">SCALP Naval</option>
    </select>
    <button type="submit">Filtrer</button>
</form>
