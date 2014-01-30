<?php

class UserTablesController extends BaseController {

    /**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function get_dashboard()
	{
		return View::make('dashboard');
	}

    public function get_listEmployees()
    {
      $term = Input::get('term');
        $term = '%'.$term.'%';
        $data = array();

        // Stores the resultset data from the employees tables into the $search variable
        $search = DB::select( DB::raw("SELECT userstable.UserID, userstable.FirstName, UsersTable.LastName FROM UsersTable WHERE FirstName + ' ' + LastName LIKE :value"), array(
                     'value' => $term,
                   ));

        /* Iterate through the query result and stores the
        *  first_name concatenates with last_name columns and
        *  store the value into the data array
        */
        foreach ($search as $result => $employeeInfo) {
            $data[] = array('id' => $employeeInfo->UserID,
                'value' => $employeeInfo->FirstName . ' '. $employeeInfo->LastName,
                'description' => $employeeInfo->FirstName . ' '. $employeeInfo->LastName);
        }
     
         // Return an array in json format
        return json_encode($data);
    }

    public function get_employeeActions(){
        // stores the term GET value
        $name = Input::get('name');
        //$name = $name.'%';
        $data = array();

        if ($name != null | $name != '') {
            $tsql = DB::table('UsersTable')
                         ->leftJoin('EmployeeAttendance', 'UsersTable.UserID', '=', 'EmployeeAttendance.UserId')
                         ->where('UsersTable.FirstName', '=', $name)
                         ->first();
        } else {
            $tsql = DB::table('UsersTable')
                         ->leftJoin('EmployeeAttendance', 'UsersTable.UserID', '=', 'EmployeeAttendance.UserId')
                         ->get();
        }

        $table = "<table>
                  <tr>
                    <td>Photo</td>
                    <td>First Name</td>
                    <td>Last name</td>
                    <td>Time</td>
                    <td>Action</td>
                    <td>Reason</td>
                  <tr/>";

                if ( !empty($tsql) ) {
                  foreach ($tsql as $result => $employeeInfo) {
                      $table .= "<tr>"; 
                      $table .= "<td>" . '<img src="images/employee.png" />'. "</td>"; 
                      $table .= "<td>" . $employeeInfo->FirstName . "</td>"; 
                      $table .= "<td>" . $employeeInfo->LastName . "</td>";
                      // $table .= "<td>" . date_format($employeeInfo->timeIn, 'd/m/Y H:i:s'). "</td>"; 
                      if ($employeeInfo->HoursWorked == "0"){
                          $table .= "<td>" . $employeeInfo->TimeIn . "</td>";                       
                          $table .= "<td>" . "Start Work" . "</td>"; 
                      } else {
                          $table .= "<td>" . $employeeInfo->TimeOut . "</td>";                      
                          $table .= "<td>" . "Stop Work" . "</td>";
                      }
                      $table .= "<td>" . $employeeInfo->ReasonLeave . "</td>"; 
                      $table .= "</tr>"; 
                  }
                } 

               $table .= "</table>";  

        return $table;
    }

    public function post_authenticate(){
        $id = Input::get('userid');
        $password = Input::get('password');
        //$password = sha1($password);
        $data = array();

        #search database
        $employee = DB::table('UsersTable')
                    ->where('UserID', '=', $id)
                    ->where('Password', '=', $password)
                    ->first();

        if (empty($employee)) {
                $error = 1;//empty employee
                $data[] = array('error' => $error); 

            return json_encode($data);
        }

        $employeeAttendance = DB::table('EmployeeAttendance')
                            ->where('UserId', '=', $employee->UserID)
                            ->where('HoursWorked', '=', '0')
                            ->first();

        if (empty($employeeAttendance)) {
            // Employee start work
            $workStatus = 0;
        } else {
            // Employee stop work
            $workStatus = 1;
        }

        $error = 0;//empty employee
        $data[] = array('FirstName' => $employee->FirstName, 
                     'FullName' => $employee->FirstName . ' ' . $employee->LastName,
                     'Action' => $workStatus,
                     'error' => $error); 

        return json_encode($data);

    }

	public function post_SaveStartWork()
    {
        // data employee attendance
        $employeeId = Input::get('userid');
        $action = Input::get('action');
        $reasonLeave = Input::get('reason');
        $timeIn = date_create()->format('Y-m-d H:i:s');
        $data = array();

        if ($action == 'Start') {
            #Insert Database
            $attendanceId = DB::table('EmployeeAttendance')
                ->insert(array('UserId' => $employeeId, 'TimeIn' => $timeIn, 'ReasonLeave' => $reasonLeave, 'Action' => $action));
             
        } else {
            $employeeAttendance = DB::table('EmployeesAttendance')
                                 ->where('UserId', '=', $employeeId)
                                 ->where('HoursWorked', '=', '0')
                                 ->first();

            $initial_date = $employeeAttendance->TimeIn;
            $end_date = $timeIn;

            // Split the initial date into pieces
            list($initial_day, $initial_hour) = explode(" ", $initial_date);
            list($year, $month, $day) = explode("-", $initial_day);
            list($hour, $minute, $second) = explode(":", $initial_hour);
            $initial_time = mktime($hour + 0, $minute + 0, $second + 0, $month + 0, $day + 0, $year);

            // Split the end date into pieces
            list($end_day, $end_hour) = explode(" ", $end_date);
            list($year, $month, $day) = explode("-", $end_day);
            list($hour, $minute, $second) = explode(":", $end_hour);
            $end_time = mktime($hour + 0, $minute + 0, $second + 0, $month + 0, $day + 0, $year);

            // Make the difference betweeen the SECONDS in the dates
            $seconds_difference = $end_time - $initial_time;

            // Calculate total hours worked
            // Divide ($seconds_difference / 60) / 60
            $total_hours_worked = ( $seconds_difference / 60 ) / 60;

            // $reason = Input::get('reason');
            // $employeeId = Input::get('employeeId');
               $resultUpdateAttendance = DB::table('EmployeesAttendance')
                ->where('id', $employeeAttendance->id)
                ->update( array( 'TimeOut' => $timeIn,
                                 'HoursWorked' => $total_hours_worked,
                                 'ReasonLeave' => $reasonLeave));   
                   
        }

        $employeeData = DB::table('UsersTable')
                        ->where('UserID','=', $employeeId)
                        ->first();

        $data[] = array("FullDescription"=>$employeeData->FirstName.' ' .$employeeData->LastName,
                "Action" => $action,
                "Reason"=>$reasonLeave,
                "Time"=>$timeIn);

        return json_encode($data);
    }
}
