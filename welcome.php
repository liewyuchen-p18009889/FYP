<!doctype html>
<html lang="en">

<head>
    <!--using external files-->
    <?php require('import.html') ?>

    <title>UTask | Welcome</title>
    <style>
        .swal-button {
            background-color: #3AAFA9;
        }
        .swal-footer {
            text-align: center;
        }
    </style>
    <!-- show sweet alert then proceed to projectList.php START -->
    <script type="text/javascript">
        $(function () {
            swal({
                title: "Welcome to UTask!",
                text: "Let's start now!",
                button: "SIGN IN"
            }).then(function () {
                window.location = "/FYP/signIn.php";
            });
        });
    </script>
    <!-- show sweet alert then proceed to projectList.php END -->
</head>

<body style="background: #def2f1">
</body>

</html>