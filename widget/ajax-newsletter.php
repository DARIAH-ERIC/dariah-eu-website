<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-type: application/json');

  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $email = $_POST['email'];
  $institution = $_POST['institution'];
  $ref = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
  if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL) === false && strpos($ref, 'dariah')){
      // MailChimp API credentials
      $apiKey = 'bfe2322cbdd0faddefb8cdf39494c8ee-us18';
      $listID = '50ab35cfde';

      // MailChimp API URL
      $memberID = md5(strtolower($email));
      $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
      $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;

      // member information
      $json = json_encode([
          'email_address' => $email,
          'status'        => 'pending',
          'merge_fields'  => [
              'FNAME'     => $fname,
              'LNAME'     => $lname,
              'MMERGE3'   => $institution
          ]
      ]);

      // send a HTTP POST request with curl
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
      curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 10);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      $result = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);

      // store the status message based on response code
      if ($httpCode == 200) {
        $msg =  'You have successfully subscribed to DARIAH’s Newsletter';
        $state = 'success';
      } else {
          switch ($httpCode) {
              case 214:
                  $msg = 'You are already subscribed';
                  $state = 'error';
                  break;
              default:
                  $msg = 'Some problem occurred, please try again';
                  $state = 'error';
                  break;
          }
      }
  } else {
      $httpCode = 400;
      $msg = 'Please enter valid email address';
      $state = 'error';
  }

  $return = array(
    "code" => $httpCode,
    "message" => $msg,
    "state" => $state
  );

  echo json_encode($return);
?>
