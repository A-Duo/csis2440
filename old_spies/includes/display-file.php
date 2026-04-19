<table class="alternating-table">
    <tbody class="glow-text" style="--glow-color: #555a">
        <tr>
            <th>Agent</th>
            <th>Code Name</th>
        </tr>
        <?php
            $file = fopen($fileName, "r") or die("Unable to open file!");
            $data = explode('||>><<||', fread($file,filesize($fileName)));
            fclose($file);
            foreach($data as $agent):
                $agent = explode(',', $agent); ?>
                <tr>
                    <td><?= $agent[0]; ?></td>
                    <td><?= $agent[1]; ?></td>
                </tr>
            <?php
            endforeach
        ?> 
    </tbody>
</table>