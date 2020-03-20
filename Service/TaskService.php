<?php


class TaskService
{
    private $MS;
    private $VS;
    private $AllTasks;

    public function __construct( MessageService $MS, ViewService $VS){
        $this->MS = $MS;
        $this->VS = $VS;
    }

    public function WeatherAPI($method, $url, $data){
        $curl = curl_init();
        switch ($method){
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'APIKEY: 111111111111111111111',
            'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }

//Check, uitwerken
    public function GetTasks(){
        $get_data = $this->WeatherAPI('GET', 'http://localhost/Groepswerken/RestAPI/api/taken', false);
        $response = json_decode($get_data, true);

        foreach ( $response as $row) {
            $task = new Task();
            $task->setId($row['taa_id']);
            $task->setDatum($row['taa_datum']);
            $task->setOmschr($row['taa_omschr']);

            $this->AllTasks[] = $task;
        }

        $this->PrintTasks();
    }

//Check, uitwerken
    public function GetOneTask($id){
        $get_data = $this->WeatherAPI('GET', 'http://localhost/Groepswerken/RestAPI/api/taak/'. $id, false);
        $response = json_decode($get_data, true);

        $task = new Task();
        $task->setId($response[0]['taa_id']);
        $task->setDatum($response[0]['taa_datum']);
        $task->setOmschr($response[0]['taa_omschr']);

        $this->AllTasks[] = $task;
        $this->PrintTasks();
    }

    public function CreateTask($datum, $task){
        $data_array = array (
            'taa_datum' => $datum,
            'taa_omschr' => $task );

        $make_task = $this->WeatherAPI('POST', 'http://localhost/Groepswerken/RestAPI/api/taken', json_encode($data_array) );
        $this->MS->AddMessage($make_task, 'info');
        header( 'Location: ../index.php');
    }

    public function EditTask($id, $datum, $task){
        $data_array = array (
            'taa_omschr' => $task,
            'taa_datum' => $datum );

        $update_task = $this->WeatherAPI('PUT', 'http://localhost/Groepswerken/RestAPI/api/taak/' .$id, json_encode($data_array) );
        $this->MS->AddMessage($update_task, 'info');
        header( 'Location: ../index.php');
    }

    public function DeleteTask( $id ){
        $delete_task = $this->WeatherAPI('DELETE', 'http://localhost/Groepswerken/RestAPI/api/taak/' . $id, false );
        $this->MS->AddMessage($delete_task, 'info');
        header( 'Location: ../index.php');
    }

    /**
     * @return mixed
     */
    public function getAllTasks()
    {
        return $this->AllTasks;
    }

    public function PrintTasks(){
        $template = $this->VS->LoadTemplate('task');
        print $this->VS->ReplaceTasks( $this->getAllTasks(), $template);
    }
}
