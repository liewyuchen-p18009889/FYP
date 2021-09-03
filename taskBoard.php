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
</head>

<body class="bg-light">
    <?php include 'header.php'; ?>
    <div class="container-fluid" style="padding: 30px 10px;">
        <div class="row" style="margin: 0 35px;">
            <div class="col-6 pl-0">
                <h3 class="text-info"><span style="cursor:pointer" onclick="openNav()">&#9776;</span> Task Board</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#addTaskModal"><i
                        class="fas fa-plus" style="font-size: 20px;"></i>&nbsp;Create
                    Task</button>
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
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#exampleModalCenter">
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
            <div class="col fixWidth bg-white shadow rounded mr-2 ml-2 p-0 d-flex justify-content-center border border-info">
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
            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div>
    <?php include 'sideMenuBar.php'; ?>
    <?php include 'footer.html'; ?>
</body>

</html>