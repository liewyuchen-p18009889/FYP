<?php
    session_start();
    include 'connectDB.php';
    require_once __DIR__ . '/vendor/autoload.php';

    if(isset($_POST['get_projectID'])){
        $projectID = $_POST['get_projectID'];
    }

    $query = "SELECT * FROM tasks 
                INNER JOIN users ON tasks.task_asignee=users.user_id 
                WHERE task_project=$projectID";
    $runQuery = mysqli_query($dbc, $query);

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
	$pdfData .= '<h1>Project Report</h1>
                    <table>
                    <tr><th>Task ID</th>
                    <th>Task Title</th>
                    <th>Task Start</th>
                    <th>Task End</th>
                    <th>Task Status</th>
                    <th>Task Asignee</th>
                    <th>Created At</th>
                    <th>Updated At</th></tr>';
    if($runQuery){
        foreach($runQuery as $row){
            $pdfData .= '<tr>
                            <td>'.$row['task_id'].'</td>
                            <td>'.$row['task_title'].'</td>
                            <td>'.date('Y-m-d', strtotime($row['task_start'])).'</td>
                            <td>'.date('Y-m-d', strtotime($row['task_end'])).'</td>
                            <td>'.$row['task_status'].'</td>
                            <td>'.$row['user_name'].'</td>
                            <td>'.$row['created_at'].'</td>
                            <td>'.$row['updated_at'].'</td>
                            </tr>';
        }
        $pdfData .= '</table>';
        $mpdf->WriteHTML($pdfData);
        
        $mpdf->Output('projectReport_'.date('Ymd', time()).'.pdf', 'D');
    }

    // echo $status;die;   //status output

    mysqli_close($dbc);
?>