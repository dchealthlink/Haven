<?php
$sel_list = ereg_replace("\(","",$search_where);
$select_list = ereg_replace('\)','',$sel_list);
$search_matrix = explode(" AND ",$select_list);

echo "<br><b>Search Criteria: </b>";
        echo "<table border=1 width=700>";
        echo ("<tr>");

        $search_matrix_count = count($search_matrix);
        for ($j = 1; $j < $search_matrix_count; $j++) {

                echo "<td>".$search_matrix[$j]."</td>";

                if (($j % 2) == 0) {
                        echo "</tr>";
                }

        }

        echo "</table>";
        echo "<br>";
?>
