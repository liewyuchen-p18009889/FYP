<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php 
        ob_start(); //to solve errors of "Cannot modify header information - headers already sent"
        session_start();
        include 'import.html';
     ?>
    <!-- Style CSS -->
    <!-- <link rel="stylesheet" href="/FYP/signInStyle.css"> -->
    <style>
        .swal-text {
            text-align: center;
        }

        .swal-footer {
            text-align: center;
        }
    </style>

    <title>UTask | Project List</title>

    <script type="text/javascript">
        // Project Datatable START
        $(document).ready(function () {
            $('#projectsTable').DataTable();
        });
        // Project Datatable END
        // Table row link START
        $(document).ready(function () {
            $(".clickable-row").click(function () {
                window.document.location = $(this).data("href");
            });
        });
        // Table row link END

        // add project START
        function submitAddProject() {
            var projectTitle = $('#inputProjectTitle').val();
            if (projectTitle.trim() == '') {
                $('.statusMsg').text('Project title is required!');
                $('#inputProjectTitle').focus();
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: '/FYP/addProjectData2.php',
                    data: 'addProjectForm=1&txtProjectTitle=' + projectTitle,
                    beforeSend: function () {
                        $('.btnAddProject').attr("disabled", "disabled");
                        $('.modal-body').css('opacity', '.5');
                    },
                    success: function (response) {
                        if (response == 'success') {
                            $('#inputProjectTitle').val('');
                            swal({
                                title: "Project added successfully!",
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                            console.log(response);
                        } else {
                            $(function () {
                                swal("Project failed to add!", "", "warning");
                            });
                            console.log(response);
                        }
                        $('.btnAddProject').removeAttr("disabled");
                        $('.modal-body').css('opacity', '');
                    }
                });
            }
        }
        // add project END 

        // Swal delete project START
        $(document).ready(function () {
            $('.btnDelPro').click(function (e) {
                e.preventDefault();
                // console.log("Hello");

                var delProID = $(this).closest("tr").find('.delProID').val();
                // console.log(delProID);
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data.",
                        icon: "error",
                        buttons: ["Cancel", "Delete"],
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "post",
                                url: "/FYP/delProjectData.php",
                                data: {
                                    "del_set": 1,
                                    "del_id": delProID,
                                },
                                success: function (response) {
                                    swal({
                                        title: "Project deleted successfully!",
                                        icon: "success",
                                    }).then((result) => {
                                        location.reload();
                                    });
                                }
                            });
                        }
                    });
            });
        });
        // Swal delete project START
    </script>
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
    <!-- <div class="container mt-4 p-0"> -->
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-6">
                <h3 class="text-info">Projects</h3>
            </div>
            <?php
                $email = $_SESSION['user_email'];
                $query1 = "SELECT * FROM users WHERE user_email='$email' AND isProjectManager='1'";
                $runQuery1 = mysqli_query($dbc, $query1);

                if(mysqli_num_rows($runQuery1) === 1){
                    $row = mysqli_fetch_assoc($runQuery1); //to fetch a result row as an associative array
            ?>
            <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addProjectModal"><i
                        class="fas fa-plus" style="font-size: 20px;"></i>&nbsp;Create
                    Project</button>
            </div>
            <?php }else{ ?>
            <div class="col-6 d-flex justify-content-end"></div>
            <?php }  ?>
            <!-- <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-primary" type="button" style="background: #3AAFA9;" data-toggle="modal"
                    data-target="#addProjectModal"><i class="fas fa-plus" style="font-size: 20px;"></i>&nbsp;Create
                    Project</button>
            </div> -->
        </div>
    </div>

    <!--add project modal START-->
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="addProjectModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create New Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- <form action="/FYP/addProjectData.php" method="post" enctype="multipart/form-data"> -->

                <div class="modal-body">
                    <form role="form">
                        <input type="hidden" name="insertProject_id" id="insertProject_id">
                        <div class="form-group m-0">
                            <label for="inputProjectTitle">Project Title:</label>
                            <input type="text" class="form-control" name="txtProjectTitle" id="inputProjectTitle"
                                aria-describedby="emailHelp" placeholder="Enter project title">
                            <p class="m-0 p-2 text-danger statusMsg"></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- <button type="submit" class="btn btn-info" name="addProjectData">Create</button> -->
                    <button type="button" class="btn btn-info btnAddProject"
                        onclick="submitAddProject()">Create</button>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
    <!--add project modal END-->
    <!-- project datatable START -->
    <div class="container-fluid mb-4">
        <div class="card shadow p-4 mb-5 ml-3 mr-3 bg-white rounded" style="min-height: 516px;">
            <table id="projectsTable" class="table table-hover" style="width:100%;">
                <thead class="bg-light">
                    <tr>
                        <th>Title</th>
                        <th>Project Manager</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                            $query2 = "SELECT * FROM projects";
                            // $query2 = "SELECT * FROM projects ORDER BY project_datetime DESC";
                            $runQuery2 = mysqli_query($dbc, $query2);

                            if($runQuery2){
                                foreach($runQuery2 as $row2){
                        ?>
                    <tr>
                        <!-- <tr class="clickable-row" data-href="/FYP/taskBoard.php"> -->
                        <td><a href="/FYP/taskBoard.php" class="text-info"><?php echo $row2['project_title']; ?></a>
                        </td>
                        <td>
                            <?php 
                                $query3 = "SELECT * FROM users WHERE user_id=".$row2['user_id'];
                                $runQuery3 = mysqli_query($dbc, $query3);

                                if($runQuery3){
                                    foreach($runQuery3 as $row3){
                                        echo $row3['user_name'];
                                    }
                                }
                                // echo $row2['project_manager']; 
                            ?>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btnEdit"><i class="fas fa-edit"
                                    style="font-size: 14px;"></i></button>
                            <!-- <button type="button" class="btn btn-danger btnDel" onclick="swalDelProject()"><i
                                    class="fas fa-trash" style="font-size: 14px;"></i></button> -->
                            <input type="hidden" class="delProID" value="<?php echo $row2['project_id']; ?>">
                            <a href="javascript:void(0)" class="btn btn-danger btnDelPro"><i class="fas fa-trash"
                                    style="font-size: 14px;"></i></a>
                        </td>
                    </tr>
                    <?php
                                }
                            }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- project datatable END -->
    <!--using external files-->
    <?php include 'footer.html'; ?>
</body>

</html>