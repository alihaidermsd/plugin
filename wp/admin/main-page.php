<?php
global $wpdb, $table_prefix;
$wp_emp = $table_prefix. "emp";

$q = "SELECT * FROM `$wp_emp`;";
$results = $wpdb->get_results($q);

ob_start()
?>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($results as $row):
        ?>
        <tr>
            <td><?php echo "$row->ID;"  ?></td>
            <td><?php echo "$row->name;"  ?></td>
            <td><?php echo "$row->email;"  ?></td>
        </tr>
        <?php
        endforeach
        ?>
    </tbody>
</table>
<?php
return ob_get_clean();