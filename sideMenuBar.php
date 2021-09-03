<div id="mySidenav" class="sidenav shadow-lg">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="/FYP/projectList.php">View All Projects</a>
    <div class="dropdown-divider"></div>
    <a href="/FYP/dashboard.php">Dashboard</a>
    <a href="/FYP/taskBoard.php">Task Board</a>
    <a href="#">Calendar</a>
</div>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>