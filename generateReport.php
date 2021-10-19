<?php
    session_start();
    include 'connectDB.php';
    require_once __DIR__ . '/vendor/autoload.php';
    date_default_timezone_set('Asia/Kuala_Lumpur');

    if(isset($_POST['get_projectID'])){
        $projectID = $_POST['get_projectID'];
    }
    // fetch data of task details
    $query1 = "SELECT * FROM tasks 
                INNER JOIN users ON tasks.task_asignee=users.user_id 
                WHERE task_project=$projectID";
    $runQuery1 = mysqli_query($dbc, $query1);

    // fetch data of user details
    $query2 = "SELECT * FROM project_members 
                INNER JOIN users ON project_members.user_id=users.user_id 
                WHERE project_id=$projectID";
    $runQuery2 = mysqli_query($dbc, $query2);
    
    // fetch data of project details
    $query3 = "SELECT * FROM projects WHERE project_id=$projectID";
    $runQuery3 = mysqli_query($dbc, $query3);
    $row3 = mysqli_fetch_assoc($runQuery3);

    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']); //to generate pdf in landscape
	// $pdfData = '';
	$pdfData .= '<style>table {
                    border-collapse: collapse;
                    width: 100%;
                }
                
                td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }
                
                tr:nth-child(even) {
                    background-color: #dddddd;
                }</style>';
    $pdfData .= '<h1>'.$row3['project_title'].'</h1>';
    // task table START
	$pdfData .= '<h2>Tasks</h2>
                    <table>
                    <tr><th>Task ID</th>
                    <th>Task Title</th>
                    <th>Task Start</th>
                    <th>Task End</th>
                    <th>Task Status</th>
                    <th>Task Asignee</th>
                    <th>Created At</th>
                    <th>Updated At</th></tr>';

    foreach($runQuery1 as $row1){
        $pdfData .= '<tr>
                        <td>'.$row1['task_id'].'</td>
                        <td>'.$row1['task_title'].'</td>
                        <td>'.date('Y-m-d', strtotime($row1['task_start'])).'</td>
                        <td>'.date('Y-m-d', strtotime($row1['task_end'])).'</td>
                        <td>'.$row1['task_status'].'</td>
                        <td>'.$row1['user_name'].'</td>
                        <td>'.date('Y-m-d', strtotime($row1['task_created_at'])).'</td>
                        <td>'.date('Y-m-d', strtotime($row1['task_updated_at'])).'</td>
                        </tr>';
    }
        $pdfData .= '</table>';
    // task table END
    // member table START
    $pdfData .= '<h2>Members</h2>
                    <table><tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Email</th>
                        <th>Joined On</th>
                    </tr>';
    // if($runQuery){
    foreach($runQuery2 as $row2){
        $pdfData .= '<tr>
                        <td>'.$row2['user_id'].'</td>
                        <td>'.$row2['user_name'].'</td>
                        <td>'.$row2['user_email'].'</td>
                        <td>'.date('Y-m-d', strtotime($row2['invited_at'])).'</td>
                    </tr>';
    }
        $pdfData .= '</table>';
        $pdfData .= '<p>Generated on: '.date('Y-m-d H:i:s').'</p>';
    // member table END

        $mpdf->WriteHTML($pdfData);
        
        $mpdf->Output('projectReport_'.date('Ymd', time()).'.pdf', 'D');

    mysqli_close($dbc);
?>