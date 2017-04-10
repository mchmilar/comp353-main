<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>


<table class="table table-hover">
    <thead>
        <tr>
            <th>Mat. ID</th>
            <th>Supplier</th>
            <th>Desc.</th>
            <th>Unit Cost</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($supplyLines as $line) {
            echo "<tr>" .
                "<td>$line->mat_id</td>" .
                "<td>$line->sid</td>" .
                "<td>$line->description</td>" .
                "<td>$line->unit_cost</td>" .
                "<td>$line->qty</td>" .
                "</tr>";
        }

    ?>
    </tbody>
</table>

