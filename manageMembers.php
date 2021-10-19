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
    <link rel="stylesheet" href="/FYP/sideMenuBarStyle.css">
    <style>
        .swal-text {
            text-align: center;
        }

        .swal-footer {
            text-align: center;
        }
    </style>

    <title>UTask | Manage Members</title>

    <script type="text/javascript">
        // member datatable START
        $(document).ready(function () {
            $('#membersTable').DataTable();
        });
        // member datatable END
        // add member START
        function submitAddMember() {
            var projectID = $('#add_member_projectID').val();
            var memberEmail = $('#add_MemberEmail').val();

            if (memberEmail.trim() == '') {
                $('.addMemberMsg').text('Email is required!');
                $('#add_MemberEmail').focus();
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "/FYP/addMemberData.php",
                    data: "addMemberForm=1&addMemberEmail=" + memberEmail + "&projectID=" + projectID,
                    beforeSend: function () {
                        $('.btnAddMember').attr("disabled", "disabled");
                        $('.modal-body').css('opacity', '.5');
                    },
                    success: function (response) {
                        if (response == 'success') {
                            $('#add_MemberEmail').val('');
                            swal({
                                title: "Member invited successfully!",
                                icon: "success",
                            }).then((result) => {
                                location.reload();
                            });
                        } else if (response == 'fail1') {
                            $(function () {
                                swal("No such user!", "", "warning");
                            });
                        } else if (response == 'fail2') {
                            $(function () {
                                swal("User is already a member!", "", "warning");
                            });
                        } else {
                            $(function () {
                                swal("Something went wrong!", "", "warning");
                            });
                        }
                        $('.btnAddMember').removeAttr("disabled");
                        $('.modal-body').css('opacity', '');
                    }
                });
            }
        }
        // add member END
        // del member START
        $(document).ready(function () {
            $('.btnDelMember').click(function (e) {
                e.preventDefault();

                var projectID = $('#add_member_projectID').val();
                var memberID = $(this).closest("tr").find('.delMemberID').val();

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
                                url: "/FYP/delMemberData.php",
                                data: {
                                    "delMember_set": 1,
                                    "project_id": projectID,
                                    "member_id": memberID,
                                },
                                success: function (response) {
                                    console.log("swal del response: " + response);
                                    if (response == 'success') {
                                        swal({
                                            title: "Member deleted successfully!",
                                            icon: "success",
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    } else if (response == 'fail') {
                                        swal({
                                            title: "Failed to delete member!",
                                            icon: "warning",
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    }
                                }
                            });
                        }
                    });
            });
        });
        // del member END
    </script>
</head>

<body class="bg-light">
    <?php
        include 'header.php';

        // check if user is the project's manager so that can access to the manage members page START
        $query1 = "SELECT * FROM project_members 
                    INNER JOIN users ON project_members.user_id = users.user_id
                    WHERE project_members.user_id={$_SESSION['user_id']} AND project_id={$_GET['id']} AND isProjectManager=1";
        $runQuery1 = mysqli_query($dbc, $query1);
        $countQuery1 = mysqli_num_rows($runQuery1);

        if($countQuery1 == 0){
            echo '<script language="javascript">
                    alert("Invalid URL!");
                    window.location.href="/FYP/projectList.php";
                    </script>';
        }
        // check if user is the project's manager so that can access to the manage members page END
        
        function formatDate($date){
            echo date('d M Y', strtotime($date));
        }
    ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-md-6 col-xs-12 p-0">
                <h3 class="text-info"><span style="cursor:pointer" onclick="openNav()"><i
                            class="fas fa-bars"></i></span> Manage Members</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addMemberModal">
                    <i class="fa fa-user-plus" style="font-size: 20px;"></i>&nbsp;Invite Member
                </button>
            </div>
        </div>
    </div>
    <!-- invite member modal START -->
    <div class="modal fade bd-example-modal-lg" id="addMemberModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invite Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="form-row">
                            <input type="hidden" name="add_member_projectID" id="add_member_projectID"
                                value="<?php echo $_GET['id']; ?>">
                            <div class="form-group col-md-12 m-0">
                                <label for="inputMemberEmail">Email:</label>
                                <input type="email" class="form-control" name="addMemberEmail" id="add_MemberEmail"
                                    aria-describedby="emailHelp" placeholder="Enter email">
                                <p class="m-0 p-2 text-danger addMemberMsg"></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!-- <button type="submit" class="btn btn-info" name="addProjectData">Create</button> -->
                    <button type="button" class="btn btn-info btnAddMember" onclick="submitAddMember()">Invite</button>
                </div>
            </div>
        </div>
    </div>
    <!-- invite member modal END -->
    <div class="container-fluid mb-4">
        <div class="card shadow p-4 mb-5 ml-3 mr-3 bg-white rounded" style="min-height: 516px;">
            <table id="membersTable" class="table table-hover" style="width:100%;">
                <thead class="bg-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Join Date</th>
                        <th>Delete</th>
                    </tr>
                    <thead>
                    <tbody>
                        <?php
                        $query2 = "SELECT * FROM project_members
                                    INNER JOIN users ON project_members.user_id=users.user_id
                                    WHERE project_id={$_GET['id']}";
                        $runQuery2 = mysqli_query($dbc, $query2);

                        foreach($runQuery2 as $row2){
                    ?>
                        <tr>
                            <td><?php echo $row2['user_name']; ?></td>
                            <td><?php echo $row2['user_email']; ?></td>
                            <td><?php formatDate($row2['invited_at']); ?></td>
                            <td>
                                <?php 
                                    // to check if project manager cannot delete himself from the project
                                    $query3 = "SELECT * FROM project_members 
                                    INNER JOIN users ON project_members.user_id = users.user_id
                                    WHERE project_members.user_id={$row2['user_id']} AND project_id={$_GET['id']} AND isProjectManager=1";
                                    $runQuery3 = mysqli_query($dbc, $query3);
                                    $countQuery3 = mysqli_num_rows($runQuery3);
                                    if($countQuery3 == 1){ 
                                ?>
                                    <button type="button" class="btn btn-danger btnDelMember" disabled>
                                    <i class="fas fa-trash" style="font-size: 14px;"></i></button>
                                <?php }else{?>
                                    <input type="hidden" class="delMemberID" id="del_memberID"
                                        value="<?php echo $row2['projectMember_id']; ?>">
                                    <button type="button" class="btn btn-danger btnDelMember">
                                        <i class="fas fa-trash" style="font-size: 14px;"></i></button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                        }
                    ?>
                    </tbody>
            </table>
        </div>
    </div>
    <?php include 'sideMenuBar.php'; ?>
    <?php include 'footer.html'; ?>
</body>

</html>