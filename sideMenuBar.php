<div id="mySidenav" class="sidenav shadow-lg">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/FYP/projectList.php">My Projects</a>
    <div class="dropdown-divider"></div>
    <a href="/FYP/dashboard.php?id=<?php echo $_GET['id'] ?>">Dashboard</a>
    <a href="/FYP/taskBoard.php?id=<?php echo $_GET['id'] ?>">Task Board</a>
    <a href="/FYP/calendar.php?id=<?php echo $_GET['id'] ?>">Calendar</a>
    <?php
        $email = $_SESSION['user_email'];
        $query1 = "SELECT * FROM users WHERE user_email='$email' AND isProjectManager='1'";
        $runQuery1 = mysqli_query($dbc, $query1);

        if(mysqli_num_rows($runQuery1) === 1){
    ?>
        <a href="/FYP/manageMembers.php?id=<?php echo $_GET['id'] ?>">Manage Members</a>
    <?php } ?>
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "280px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>