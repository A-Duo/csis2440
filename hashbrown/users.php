<?php 
    include 'includes/header.php';
    include 'includes/db-helper.php';

    // error_reporting(-1);
    // ini_set( 'display_errors', 1 );
?>
    <table class="alternating-table">
        <tbody class="glow-text" style="--glow-color: #555a">
            <tr>
                <th>Username</th>
                <th>Password</th>
            </tr>
            <?php
                $conn = startSQLConnection();
                $results = $conn->query('SELECT username, password FROM secureusers;');
                while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)):
                ?>
                    <tr>
                        <td><?=$row['username']?></td>
                        <td><?=$row['password']?></td>
                    </tr>
            <?php 
                endwhile;
                $conn->close();
            ?>
        </tbody>
    </table>

<?php include 'includes/footer.php' ?>