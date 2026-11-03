<?php
$conn = mysqli_connect("localhost", "root", "", "pap2");

$limit_per_page = 5;
$page = "";
$page = isset($_POST["page_no"]) ? $_POST["page_no"] : 1;
$offset = ($page - 1) * $limit_per_page;

//$sql = "SELECT * FROM students LIMIT {$offset},{$limit_per_page}";
$sql = "SELECT * FROM students ORDER BY id DESC LIMIT {$offset}, {$limit_per_page}";

$sql_total = "SELECT * FROM students"; //for pagination

$result = mysqli_query($conn, $sql);
$records = mysqli_query($conn, $sql_total);
$total_records = mysqli_num_rows($records);
$total_pages = ceil($total_records / $limit_per_page);
$output = "";
if (mysqli_num_rows($result) > 0) {
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
    while ($row = mysqli_fetch_assoc($result)) {
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

    //normal pagination:-

    /* $output .= "<div id='pagination'>";
           
           for ($i=1; $i <= $total_pages ; $i++) {          
            $class_name = ($i == $page) ? "active" : "";
            $output .= "<a class='{$class_name}' id='{$i}' href='' >{$i}</a>";
           }
    $output .= "</div>"; */




    //  Bootstrap Pagination:-  
    
    $output .= '<nav aria-label="Page navigation example">';
    $output .= '<ul class="pagination justify-content-center">';

    // Previous Button
    if ($page > 1) {
        $prev = $page - 1;
        $output .= "<li class='page-item'><a class='page-link' href='' id='{$prev}'>Previous</a></li>";
    } else {
        $output .= "<li class='page-item disabled'><span class='page-link'>Previous</span></li>";
    }

    // Page Numbers
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $page) ? "active" : "";
        $output .= "<li class='page-item {$active}'><a class='page-link' href='' id='{$i}'>{$i}</a></li>";
    }

    // Next Button
    if ($page < $total_pages) {
        $next = $page + 1;
        $output .= "<li class='page-item'><a class='page-link' href='' id='{$next}'>Next</a></li>";
    } else {
        $output .= "<li class='page-item disabled'><span class='page-link'>Next</span></li>";
    }

    $output .= '</ul>';
    $output .= '</nav>';


    echo $output;
} else {
    echo "<h1>DataBase is Empty</h1>";
}
