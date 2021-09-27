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

        .swal-button {
            background-color: #3AAFA9;
        }

        .swal-footer {
            text-align: center;
        }
    </style>

    <title>UTask | Task Board</title>
    <style>
        .scrollBar {
            display: flex;
            overflow-x: auto;
        }

        .fixWidth {
            -ms-flex: 0 0 354px;
            flex: 0 0 354px;
        }
    </style>
    <!-- drag START -->
    <script>
        $(function () {
            $("#drag1, #drag2, #drag3, #drag4").sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        });
    </script>
    <!-- drag END -->
    <!-- <script type="text/javascript">
        new Sortable(document.elementById('drag1'), {
            group: 'shared',
            aniamtion: 150,
            multiDrag: true,
            fallbackTolerance: 3
        });

        new Sortable(document.elementById('drag2'), {
            group: 'shared',
            aniamtion: 150,
            ghostClass: 'bg-info'
        });
    </script> -->

    <!-- add member START -->
    <script>
        function getProjectID() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const projectID = urlParams.get('id');

            return projectID;
        }

        function submitAddMember() {
            var projectID = getProjectID();
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
    </script>
    <!-- add member END -->
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-md-6 col-xs-12 p-0">
                <h3 class="text-info"><span style="cursor:pointer" onclick="openNav()">&#9776;</span> Task Board</h3>
            </div>
            <div class="col-md-6 col-xs-12 p-0 d-md-flex justify-content-end">            
                <?php
                $email = $_SESSION['user_email'];
                $query1 = "SELECT * FROM users WHERE user_email='$email' AND isProjectManager='1'";
                $runQuery1 = mysqli_query($dbc, $query1);

                if(mysqli_num_rows($runQuery1) === 1){
                    $row = mysqli_fetch_assoc($runQuery1); //to fetch a result row as an associative array
                ?>
                <button class="btn btn-info mr-1" type="button" data-toggle="modal" data-target="#addMemberModal">
                    <i class="fa fa-user-plus" style="font-size: 20px;"></i>&nbsp;Invite Member
                </button>
                <?php } ?>
                <button class="btn btn-info ml-1" type="button" data-toggle="modal" data-target="#addTaskModal">
                    <i class="fas fa-plus" style="font-size: 20px;"></i>&nbsp;Create Task
                </button>
            </div>
            <!-- <div class="col-6 d-flex justify-content-end"></div> -->
            <!-- <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-primary" type="button" style="background: #3AAFA9;" data-toggle="modal"
                    data-target="#addProjectModal"><i class="fas fa-plus" style="font-size: 20px;"></i>&nbsp;Create
                    Task</button>
            </div> -->
        </div>
    </div>
    <div class="container-fluid mb-3">
        <div class="scrollBar" style="margin: 0 3px; min-height: 600px;">
            <!-- 1st column START -->
            <div
                class="col fixWidth bg-white shadow rounded mr-2 ml-2 p-0 d-flex justify-content-center border border-info">
                <div class="container connectedSortable" id="drag1">
                    <h5 class="d-flex justify-content-center text-info  mt-3">TO DO</h5>

                    <div class="card bg-light mt-3">
                        <div class="card-body p-2">
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#updTaskModal">
                                <h5 class="card-title">Card title1</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                                <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                            </button>
                        </div>
                    </div>


                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Card title2</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
                            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- 1st column END -->
            <!-- 2nd column START -->
            <div
                class="col fixWidth bg-white shadow rounded mr-2 ml-2 p-0 d-flex justify-content-center border border-info">
                <div class="container connectedSortable" id="drag2">
                    <h5 class="d-flex justify-content-center text-info  mt-3">IN PROGRESS</h5>
                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Card title3</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle3</h6>
                            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                        </div>
                    </div>
                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Card title4</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle4</h6>
                            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- 2nd column END -->
            <!-- 3rd column START -->
            <div
                class="col fixWidth bg-white shadow rounded mr-2 ml-2 p-0 d-flex justify-content-center border border-info">
                <div class="container connectedSortable" id="drag3">
                    <h5 class="d-flex justify-content-center text-info  mt-3">TESTING</h5>
                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Card title6</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle6</h6>
                            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                        </div>
                    </div>
                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Card title5</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle5</h6>
                            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- 3rd column END -->
            <!-- 4th column START -->
            <div
                class="col fixWidth bg-white shadow rounded mr-2 ml-2 p-0 d-flex justify-content-center border border-info">
                <div class="container connectedSortable" id="drag4">
                    <h5 class="d-flex justify-content-center text-info  mt-3">DONE</h5>
                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Card title7</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle6</h6>
                            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                        </div>
                    </div>
                    <div class="card bg-light mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Card title8</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Card subtitle5</h6>
                            <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- 4th column END -->
            <!-- <div class="col-3 bg-white shadow rounded mr-1 ml-1">b</div>
            <div class="col-3 bg-white shadow rounded mr-1 ml-1">c</div> -->
        </div>
        <!-- add task modal START -->
        <div class="modal fade bd-example-modal-lg" id="addTaskModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create New Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-row">
                                <input type="hidden" name="insertTask_id" id="insertTask_id">
                                <div class="form-group col-md-12 m-0">
                                    <label for="inputTaskTitle">Title:</label>
                                    <input type="text" class="form-control" name="addTaskTitle" id="add_taskTitle"
                                        aria-describedby="emailHelp" placeholder="Enter task title">
                                    <p class="m-0 p-2 text-danger statusMsg"></p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTaskStart">Start date:</label>
                                    <input type="date" class="form-control" id="inputEmail4"
                                        placeholder="Select start date">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTaskEnd">End date:</label>
                                    <input type="date" class="form-control" id="inputPassword4"
                                        placeholder="Select end date">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTaskStart">Asignee:</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputTaskEnd">Status:</label>
                                    <select id="inputState" class="form-control">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12 m-0">
                                    <label for="inputTaskDescrp">Description:</label>
                                    <!-- <input type="text" class="form-control" name="addTaskDescrp" id="add_taskDescrp"
                                            aria-describedby="emailHelp" placeholder="Enter task description"> -->
                                    <textarea class="form-control" name="addTaskDescrp" id="summernote"></textarea>
                                    <p class="m-0 p-2 text-danger statusMsg"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <!-- <button type="submit" class="btn btn-info" name="addProjectData">Create</button> -->
                        <button type="button" class="btn btn-info btnAddTask" onclick="submitAddTask()">Create</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- add task modal END -->
        <!-- edit task modal START -->
        <div class="modal fade bd-example-modal-lg" id="updTaskModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <input type="hidden" name="updateTask_id" id="updateTask_id">
                            <div class="form-group m-0">
                                <label for="inputTaskTitle">Task Title:</label>
                                <input type="text" class="form-control" name="addTaskTitle" id="add_taskTitle"
                                    aria-describedby="emailHelp" placeholder="Enter task title">
                                <p class="m-0 p-2 text-danger statusMsg"></p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <!-- <button type="submit" class="btn btn-info" name="addProjectData">Create</button> -->
                        <button type="button" class="btn btn-info btnAddTask" onclick="submitAddTask()">Create</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- edit task modal END -->
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
                                <input type="hidden" name="insertMember_id" id="insertMember_id">
                                <input type="hidden" name="projectID">
                                <div class="form-group col-md-12 m-0">
                                    <label for="inputTaskTitle">Email:</label>
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
                        <button type="button" class="btn btn-info btnAddMember"
                            onclick="submitAddMember()">Invite</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- invite member modal END -->
    </div>
    <!-- </div> -->
    <script type="text/javascript">
        $('#summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link']],
                ['misc', ['undo', 'redo']],
            ],
            height: 250
        });
    </script>
    <?php include 'sideMenuBar.php'; ?>
    <?php include 'footer.html'; ?>
</body>

</html>