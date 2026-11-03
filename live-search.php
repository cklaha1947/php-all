<?php

$search_term=$_POST["search_term"];
$conn = mysqli_connect("localhost", "root", "", "pap2");
$sql_total = "SELECT * FROM students WHERE name LIKE '%{$search_term}%' OR gender LIKE '%{$search_term}%' OR stream LIKE '%{$search_term}%' OR subject LIKE '%{$search_term}%' "; //for pagination
$records = mysqli_query($conn, $sql_total);
$output = "";
if (mysqli_num_rows($records) > 0) {
    $output .= "
    
            <table class='table'>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Stream</th>
                    <th>Subject</th>
                    <th>Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    
                </tr>
                </thead>
            <tbody>
    ";
    while ($row = mysqli_fetch_assoc($records)) {
        $output .= "
                    
                        <tr>
                            <td>{$row["name"]}</td>
                            <td>{$row["gender"]}</td>
                            <td>{$row["stream"]}</td>
                            <td>{$row["subject"]}</td>
                            <td><img style='width: 100px;' src='./image_folder/{$row["stdimg"]}' alt='Image not available'></td>
                            <td><button class='btn btn-warning edit-btn' data-eid='{$row["id"]}' >Edit</button></td>
                            <td><button class='btn btn-danger delete-btn' data-did='{$row["id"]}' >Delete</button></td>
                            
                    
                         </tr>
        ";
    }
    $output .= "
                            </tbody>
                </table>
    ";

  

    echo $output;
} else {
    echo "<h1>Record not found...</h1>";
}

?>
