<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .parent1 {
            width: 100%;
            height: 100vh;
            background-color: gray;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            display: none;
        }

        .form-parent {
            width: 45%;
            height: 55%;
            background-color: white;
            border: 1px solid black;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            position: relative;
        }

        .form-header {
            width: 100%;
            padding: 15px 20px;
            box-sizing: border-box;
            position: absolute;
            top: 0;
            left: 0;
            border-bottom: 1px solid green;
        }

        .fhc {
            display: flex;
            justify-content: space-between;
            /* <-- use this instead of space-around */
            align-items: center;
            width: 100%;
        }

        .cross {
            border-radius: 50%;
            background-color: red;
            color: white;
            padding: 5px;
            width: 6%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        .form-body {
            overflow-y: scroll;
        }

        #autocomplete {
            position: relative;
            /* container should be relative */
        }

        #name-list {
            position: absolute;
            /* dropdown will float above */
            top: 100%;
            /* position just below the input */
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            z-index: 999;
            /* higher than load-data or any other element */
        }

        #load-data {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    <h1>Chanchal</h1>
    <form id="addform" class="form-design" action="ins.php" method="POST" enctype="multipart/form-data">
        <div> <label>Name: <input type="text" name="name" required></label></div>
        <div>
            <h4>Gender: </h4>
            <label>Male <input type="radio" name="gender" value="Male" required></label>
            <label>Female <input type="radio" name="gender" value="Female"></label>
            <label>Other <input type="radio" name="gender" value="Other"></label>
        </div>
        <div>
            <h4>Stream</h4>
            <select name="stream" required>
                <option value="">--Select--</option>
                <option value="MCA">MCA</option>
                <option value="BCA">BCA</option>
                <option value="MBA">MBA</option>
                <option value="MSc">MSc</option>
                <option value="BTech">BTech</option>
                <option value="BBA">BBA</option>
            </select>
        </div>
        <div>
            <h4>Subject: </h4>
            <label>C <input type="checkbox" name="sub[]" value="C"></label>
            <label>C++ <input type="checkbox" name="sub[]" value="C++"></label>
            <label>Java <input type="checkbox" name="sub[]" value="Java"></label>
            <label>Python <input type="checkbox" name="sub[]" value="Python"></label>
        </div>
        <div> <label>Choose Image: <input type="file" name="simg" required></label></div>
        <div><input type="submit" name="save" value="Save"></div>

    </form>
    <hr>
    <!--  live-search -->
    <div>
        <label class="btn btn-success">Live-Search:<input type="search" name="search" id="search"></label>
    </div>
    <hr>
    <!-- autocomplete search -->
    <h6>Auto Complete Search</h6>
    <form id="auto-search">
        <div id="autocomplete">
            <input type="text" id="name-box" placeholder="Enter Name" autocomplete="off">
            <div id="name-list"></div>
        </div>
        <input type="submit" value="Search" id="search-btn">
    </form>
    <hr>

    <div id="load-data"></div>
    <hr>
    <!--  modal box for update-data -->
    <div class="parent1">
        <div class="form-parent">
            <div class="form-header">
                <div class="fhc">
                    <div>
                        <h2>Update-Form</h2>
                    </div>
                    <div class="cross" id="close-btn">X</div>
                </div>

            </div>
            <div id="update-form" class="form-body">

            </div>

        </div>

    </div>






    <script src="./js/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            //load-table:-
            function loadTable(page) {
                $.ajax({
                    url: "ajax-load.php",
                    type: "POST",
                    data: {
                        page_no: page
                    },
                    success: function(data) {
                        $('#load-data').html(data);
                    }
                });
            }
            loadTable();

            //pagination:-
            $(document).on("click", ".pagination .page-link", function(e) {
                e.preventDefault();
                var page_id = $(this).attr("id");
                loadTable(page_id);
            });

            //insert:-
            $('#addform').on("submit", function(e) {
                e.preventDefault();

                var formdata = new FormData(this);

                $.ajax({
                    url: "ins.php",
                    type: "POST",
                    data: formdata,
                    contentType: false,
                    processData: false,
                    success: function(data) {

                        if (data == 1) {
                            alert("Data inserted successfully.");
                        } else {
                            alert("Data not inserted .");
                        }
                        $('#addform')[0].reset();
                        loadTable();
                    }
                });
            });

            //delete:-
            $(document).on("click", ".delete-btn", function() {
                var studentId = $(this).data("did");

                $.ajax({
                    url: "ajax-delete.php",
                    type: "POST",
                    data: {
                        id: studentId
                    },
                    success: function(data) {
                        if (data == 1) {
                            alert("data deleted successfully.");
                        } else {
                            alert("data not deleted.");
                        }
                        loadTable();
                    }
                });
            });

            //update-form open:-
            $(document).on("click", ".edit-btn", function() {
                var studentId = $(this).data("eid");
                $.ajax({
                    url: "load-update-form.php",
                    type: "POST",
                    data: {
                        id: studentId
                    },
                    success: function(data) {
                        $("#update-form").html(data);
                        $(".parent1").fadeIn("fast");
                    }
                });
            });

            // Live-Search Data:-
            $('#search').on("keyup", function() {
                //console.log("keyup...")
                var search_term = $(this).val();
                if (search_term !== "") {
                    $.ajax({
                        url: "live-search.php",
                        type: "POST",
                        data: {
                            search_term: search_term
                        },
                        success: function(data) {
                            $('#load-data').html(data);
                        }
                    });
                } else {
                    loadTable();
                }
            });

            //autocomplete-search:-
            $("#name-box").keyup(function() {
                var name = $(this).val();
                if (name != "") {
                    $.ajax({
                        url: "load-name.php",
                        method: "POST",
                        data: {
                            name: name
                        },
                        success: function(data) {
                            $("#name-list").fadeIn("fast").html(data);
                        }
                    });
                } else {
                    $("#name-list").fadeOut();
                }
            });
            $(document).on("click", "#name-list li", function() {
                $("#name-box").val($(this).text());
                $("#name-list").fadeOut();
            });
            $("#search-btn").on("click", function(e) {
                e.preventDefault();
                var name = $("#name-box").val();
                if (name == "") {
                    alert("Please enter the name...");
                } else {
                    $.ajax({
                        url: "load-table-auto-search.php",
                        method: "POST",
                        data: {
                            name: name
                        },
                        success: function(data) {
                            console.log(data);
                            $("#load-data").html(data);
                        }
                    });
                }
            });





        });
    </script>
</body>

</html>