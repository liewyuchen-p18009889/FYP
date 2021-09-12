<?php
    session_start();
    include 'connectDB.php';

    $errorsAddProjectArr = array();

    if(isset($_POST['addProjectData'])){
        //validate function
        function validate($data){
            $data = trim($data);                //to remove whitespace and other predefined characters from both sides of a string.
            $data = stripslashes($data);        //to remove backslashes
	        $data = htmlspecialchars($data);    //to convert some predefined characters to HTML entities

	        return $data;
        }

        $projectTitle = validate($_POST['txtProjectTitle']);
        $projectManager = validate($_SESSION['user_id']);

        //ensure form fields are filled properly
		if(empty($projectTitle)){
			array_push($errorsAddProjectArr, "Project title is required! Please try again!");
		}

        //no errors
        if(count($errorsAddProjectArr) == 0){
            $query = "INSERT INTO projects (project_title, project_manager, project_datetime) 
			VALUES ('$projectTitle', '$projectManager', NOW())";
            $runQuery = mysqli_query($dbc, $query);

            if($runQuery){
				$_SESSION['status'] = "success"; //to display alert message in projectList.php
				header('Location: /FYP/projectList.php');
			}else{
				$_SESSION['status'] = "fail"; //to display alert message in projectList.php
				header('Location: /FYP/projectList.php');
			}
        }else{
            //display error message in alert
			foreach($errorsAddProjectArr as $errorsAddProjectMsg){
				echo '<script type="text/javascript">alert("'.$errorsAddProjectMsg.'");</script>';
            }

			$_SESSION['status'] = "fail";
            
			//redirect to projectList.php
			echo '<script type="text/javascript">window.location.href = "/FYP/projectList.php";</script>';
        }
    }
    mysqli_close();
?>