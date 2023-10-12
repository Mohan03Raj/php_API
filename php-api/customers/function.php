<?php

require  '../inc/dbcon.php';

function error422($message){

    $data = [
        'status' => 422,
         'message' => $message,
      ];
     header("HTTP/1. 422 Unprocessable Entity");
     echo json_encode($data);
     exit();
}

function storeCustomer($customerInput){

    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if(empty(trim($name))){

        return error422('Enter your name');
    }elseif(empty(trim($email))){

        return error422('Enter your email');
    }elseif(empty(trim($phone))){

        return error422('Enter your phone');
    }
    else{
        $query = "INSERT INTO customers(name,email,phone) values ('$name, $email, $phone')";
        $result = mysqli_query($conn, $query);

        if ($result){

            $data = [
                'status' => 201,
                 'message' =>'Customer Created Succesfully',
              ];
             header("HTTP/1. 201 Created");
             echo json_encode($data);

        }else{
            $data = [
                'status' => 500,
                 'message' =>'Internal Server Error',
              ];
             header("HTTP/1. 500 Internal Server Error");
             echo json_encode($data);

        }
    }
}

function  getCustomerList(){

   global $conn;

   $query = "SELECT * FROM sustomers";
   $query_run  = mysqli_query($conn,$query);

   if($query_run){

          if (mysqli_num_rows($query_run) > 0){

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                 'message' =>'Customer List Fetched Successfully',
                 'data' => $res
              ];
             header("HTTP/1. 200 SUCCESS");
             echo json_encode($data);
          }else{
            $data = [
                'status' => 404,
                 'message' =>'No Customer Found',
              ];
             header("HTTP/1. 404 No Customer Found");
             echo json_encode($data);

          }

   }
   else
   {
    $data = [
        'status' => 500,
         'message' =>'Internal Server Error',
      ];
     header("HTTP/1. 500 Internal Server Error");
     echo json_encode($data);


   }
}
?>