<?php
require '../vendor/autoload.php';
require 'Mailer.php';

$mail = new SendMail($_POST);
$validate = $mail->validate();
if(!$validate['isValid']){
 echo json_encode(['success' => false, 'message' =>  $validate['errorMsg']]);
 return;
}

$isMailSentToAdmin = $mail->sendEnquiryToAdmin();
if($isMailSentToAdmin != 'success' ){
    echo json_encode(['success' => false, 'message' =>  'ghf'.$isMailSentToAdmin]);
    return;
}

$isUserConfirmationSent = $mail->sendEnquiryConfirmation();
echo json_encode(['success' => true, 'message' =>  'We appreciate you contacting us. One of our colleagues will get back in touch with you soon! Have a great day!']);
return;

class SendMail {

    protected $data;
    protected $name;
    protected $email;

    public function __construct($data)
    {
        $this->data = $data;
        $this->name = $this->testInput($data['fullname']);
        $this->email = $this->testInput($data['email']);
    }
    /**
     * This function send enquiry confirmation through mail
     */
    public function sendEnquiryConfirmation()
    {
        $mail = new Mailer();
        $sendTo = $this->email;
        $reciverName = $this->name;
        $bodyContent = $this->getSenderConfirmationMailContent($this->data);
        $html = $bodyContent;
        $subject = 'Seprate Web - No Reply';
        return $mail->sendMail($reciverName, $sendTo, $subject, $html);
    }

    /**
     * This function send enquiry details to admin thorugh mail
     */
    public function sendEnquiryToAdmin()
    {
        $mail = new Mailer();
        $sendTo = 'vinod.eptins@gmail.com';
        $reciverName = $this->name;
        $bodyContent = $this->getMailContentForAdmin($this->data);
        $html = $bodyContent;
        $subject = 'Enquiry From - '.$this->name;
        return $mail->sendMail($reciverName, $sendTo, $subject, $html);
    }

    /* This function to get the mail html content for user
     * @param array $data posted data
     * @return string
     */
    protected function getSenderConfirmationMailContent($data)
    {
        $html = '<!DOCTYPE html>
        <html lang="en" >
          <head>
            <meta charset="UTF-8">
            <title>Email Template</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
            <style>
            *{margin: 0; padding: 0;}
            .sw-email-body{max-width: 540px; width: 100%; margin: 0 auto; font-family: \'Poppins\', sans-serif;}
            .logo{text-align: center;margin-bottom: 8px;}
            .emailheader{ text-align: center; background: #c8dbff;  padding:20px; }
            .fieldset{border-bottom: 1px solid #c8dbff;   padding: 10px;   font-size: 15px;}
            .emailbodystart{margin-top: 10px; background: #fff;}
            .messagebody{  grid-template-columns: auto;  background: #fff;  padding:10px 10px 20px 10px;  }
            .footer{  text-align: center; background: #0652dd; color: #fff; padding: 20px; font-size: 14px;  }
            .footer p{font-size: 15px; line-height: 22px;}
            .companytt{  font-size: 18px;  margin: 0 0 10px 0;}
            .footer a{color: #fff; text-decoration: none;}
            .sw-service{margin: 0 0 8px 0;}
            .logo-header img{width: 200px; margin-bottom: 10px;}
            .emailheader p{font-size: 15px; line-height: 22px;}
            .contactuserdata{font-weight: 600;   float: right;   width: 66%;   flex: 0 0 66%;     font-size: 14px;}
            .contactuser{width: 30%;  float: left; flex: 0 0 30%; font-size: 14px;}
            .usermessage{line-height: 1.4;  width: 100%;  margin-top: 15px;}
            .messagebody .contactuser {width:100%}
            .clear{clear: both;}
            .ft-service ul {margin-bottom: 5px;}
            .ft-service li {display: inline; padding: 0 4px;}
            .ft-service li a{color:#fff;}
            </style>
          </head>
          <body>
            <div class="sw-email-body">
              <div class="emailheader">
                <div class="logo-header"><img src="https://separateweb.com/demo-niwax/images/logo.png" alt="logo"></div>
                <p>We appreciate you contacting us. One of our colleagues will get back in touch with you soon! Have a great day!</p>
              </div>
              <div class="emailbodystart">
                <div class="fieldset">
                  <div class="contactuser">Customer Name</div>
                  <div class="contactuserdata">'.$data['fullname'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Mobile Number</div>
                  <div class="contactuserdata">'.$data['mobile_number'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Email Addrerss</div>
                  <div class="contactuserdata">'.$data['email'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Interested In</div>
                  <div class="contactuserdata">'.$data['interested_in'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Customer Location</div>
                  <div class="contactuserdata">'.$data['your_location'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Skype/Whatsapp</div>
                  <div class="contactuserdata">'.$data['skype_whatsapp_no'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset messagebody">
                  <div class="contactuser">Customer Message</div>
                  <div class="contactuserdata usermessage">'.$data['description'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="footer">
                  <h3 class="companytt">Niwax Contact Form</h3>
                  <div class="ft-service">
                  <ul>
                  <li><a href="https://www.google.com/">Websites</a></li>
                  <li><a href="https://www.google.com/">Mobile App</a></li>
                  <li><a href="https://www.google.com/">Graphic Design</a></li>
                  <li><a href="https://www.google.com/">Digital Marketing</a></li>
                  </div>
                  <p>Website: www.yourwebsite.com</p>
                  <p>Email: info@yourwebsite.com</p>
                  <p>Call: +91-12344567890</p>
                  <p>Jaipur, Rajasthan, India</p>
                </div>
              </div>
            </div>

          </body>
        </html>';
        return $html;
    }

    /* This function to get the mail html content for admin
     * @param array $data posted data
     * @return string
     */
    protected function getMailContentForAdmin($data)
    {
        $html = '<!DOCTYPE html>
        <html lang="en" >
          <head>
            <meta charset="UTF-8">
            <title>Email Template</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
            <style>
            *{margin: 0; padding: 0;}
            .sw-email-body{max-width: 540px; width: 100%; margin: 0 auto; font-family: \'Poppins\', sans-serif;}
            .logo{text-align: center;margin-bottom: 8px;}
            .emailheader{ text-align: center; background: #c8dbff;  padding:20px; }
            .fieldset{border-bottom: 1px solid #c8dbff;   padding: 10px;   font-size: 15px;}
            .emailbodystart{margin-top: 10px; background: #fff;}
            .messagebody{  grid-template-columns: auto;  background: #fff;  padding:10px 10px 20px 10px;  }
            .footer{  text-align: center; background: #0652dd; color: #fff; padding: 20px; font-size: 14px;  }
            .footer p{font-size: 15px; line-height: 22px;}
            .companytt{  font-size: 18px;  margin: 0 0 10px 0;}
            .footer a{color: #fff; text-decoration: none;}
            .sw-service{margin: 0 0 8px 0;}
            .logo-header img{width: 200px; margin-bottom: 10px;}
            .emailheader p{font-size: 15px; line-height: 22px;}
            .contactuserdata{font-weight: 600;   float: right;   width: 66%;   flex: 0 0 66%;     font-size: 14px;}
            .contactuser{width: 30%;  float: left; flex: 0 0 30%; font-size: 14px;}
            .usermessage{line-height: 1.4;  width: 100%;  margin-top: 15px;}
            .messagebody .contactuser {width:100%}
            .clear{clear: both;}
            .ft-service ul {margin-bottom: 5px;}
            .ft-service li {display: inline; padding: 0 4px;}
            .ft-service li a{color:#fff;}
          </style>
          </head>
          <body>
            <div class="sw-email-body">
              <div class="emailheader">
                <div class="logo-header"><img src="https://separateweb.com/demo-niwax/images/logo.png" alt="logo"></div>
                <p>You got an email from your website!</p>
              </div>
              <div class="emailbodystart">
                <div class="fieldset">
                  <div class="contactuser">Customer Name</div>
                  <div class="contactuserdata">'.$data['fullname'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Mobile Number</div>
                  <div class="contactuserdata">'.$data['mobile_number'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Email Addrerss</div>
                  <div class="contactuserdata">'.$data['email'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Interested In</div>
                  <div class="contactuserdata">'.$data['interested_in'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Customer Location</div>
                  <div class="contactuserdata">'.$data['your_location'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset">
                  <div class="contactuser">Whatsapp No</div>
                  <div class="contactuserdata">'.$data['skype_whatsapp_no'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="fieldset messagebody">
                  <div class="contactuser">Customer Message</div>
                  <div class="contactuserdata usermessage">'.$data['description'].'</div>
                  <div class="clear"></div>
                </div>
                <div class="footer">
                  <h3 class="companytt">Niwax Contact Form</h3>
                  <div class="ft-service">
                  <ul>
                  <li><a href="https://www.google.com/">Websites</a></li>
                  <li><a href="https://www.google.com/">Mobile App</a></li>
                  <li><a href="https://www.google.com/">Graphic Design</a></li>
                  <li><a href="https://www.google.com/">Digital Marketing</a></li>
                  </div>
                  <p>Website: www.yourwebsite.com</p>
                  <p>Email: info@yourwebsite.com</p>
                  <p>Call: +91-12344567890</p>
                  <p>Jaipur, Rajasthan, India</p>
                </div>
              </div>
            </div>
          </body>
        </html>';
        return $html;
    }

    public function validate()
    {
        $isValid = 1;
        $errorMsg = '';
        $this->data['fullname'] = $this->testInput($this->data['fullname']);
        $this->data['mobile_number'] = $this->testInput($this->data['mobile_number']);
        $this->data['email'] = $this->testInput($this->data['email']);
        $this->data['interested_in'] = $this->testInput($this->data['interested_in']);
        $this->data['your_location'] = $this->testInput($this->data['your_location']);
        $this->data['skype_whatsapp_no'] = $this->testInput($this->data['skype_whatsapp_no']);
        $this->data['description'] = $this->testInput($this->data['description']);
        $this->data['agree'] = $this->testInput($this->data['agree']);
        if(empty($this->data['fullname'])){
            $errorMsg = "Name is required.";
            $isValid = 0;
        } elseif(empty($this->data['mobile_number'])){
            $errorMsg = "Mobile Number is required.";
            $isValid = 0;
        } elseif(empty($this->data['email'])){
            $errorMsg = "Email is required.";
            $isValid = 0;
        } elseif(empty($this->data['interested_in'])){
            $errorMsg = "Please select your intrest.";
            $isValid = 0;
        } elseif(empty($this->data['your_location'])){
            $errorMsg = "Please provide your location.";
            $isValid = 0;
        } elseif(empty($this->data['skype_whatsapp_no'])){
            $errorMsg = "Please provide Skype/WhatsApp Number.";
            $isValid = 0;
        } elseif(empty($this->data['description'])){
            $errorMsg = "Please brief about your project.";
            $isValid = 0;
        } elseif(empty($this->data['agree'])){
            $errorMsg = "Please accept terms and conditions.";
            $isValid = 0;
        }
        return  array('isValid' => $isValid, 'errorMsg' => $errorMsg);
    }

    /**
     * Check input data
     */
    public function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
