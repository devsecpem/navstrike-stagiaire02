<?php
/**
 * NavStrike - Mission Planning Template
 *
 * Displays mission list and planning interface.
 */
?>
<h2>Planification de Missions</h2>

<?php if (isset($results) && $results && mysqli_num_rows($results) > 0): ?>
    <table border="1">
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Zone</th>
            <th>Priorite</th>
            <th>Notes Commandant</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($results)): ?>
            <tr>
                <td><?php echo $row['code']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['zone']; ?></td>
                <td><?php echo $row['priority']; ?></td>
                <td><?php echo $row['commander_notes']; ?></td>
                <td>
                    <a href="?page=mission-briefing&file=<?php echo $row['briefing_file']; ?>">Briefing</a>
                    <a href="?page=mission-export&mission_id=<?php echo $row['id']; ?>&format=pdf">Export PDF</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Aucune mission en cours.</p>
<?php endif; ?>
