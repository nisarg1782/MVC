<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'vendor/autoload.php'; 


class Customer_Controller_Index extends Core_Controller_Customer_Action
{
    protected $_allowed = [
        "register",
        "login",
        "checkEmail",
        "forgot",
        "forgotPassword",
         "sendOtp",
        "generateOtp"

    ];
    public function registerAction()
    {
        $layout = Mage::getBlock("core/layout");
        $registration = $layout->createBlock("customer/account_register")
            ->setTemplate("customer/register.phtml");
        $layout->getChild("content")
            ->addChild("registration", $registration);
        $layout->toHtml();
    }
    public function loginAction()
    {
        $layout = Mage::getBlock("core/layout");
        $registration = $layout->createBlock("customer/account_login")
            ->setTemplate("customer/login.phtml");
        $layout->getChild("content")
            ->addChild("login", $registration);
        $layout->toHtml();
    }
    public function registerCustomerAction()
    {
        $layout = Mage::getBlock("core/layout");
        $customer = Mage::getModel("core/request")->getParam("customer");

        $customer = Mage::getSingleton("customer/session")
            ->getCustomer()
            ->setData($customer)
            ->Save();

        $layout = Mage::getBlock("core/layout");
        $url = $layout->getUrl("Customer/index/login");
        header("location:$url");
    }
    public function loginCustomerAction()
    {
        $login_data = Mage::getModel("core/request")->getParam("customer");
        $session = Mage::getSingleton("core/session");

        $model = Mage::getSingleton("customer/session")
            ->getCustomer()
            ->getCollection()
            ->addFieldToFilter("email", ["=" => $login_data["email"]]);
        $data = $model->getData();
        if (!empty($data)) {
            $password = $data[0]->getPassword();
            $customer_id = $data[0]->getCustomerId();
            if ($password == $login_data["password"]) {
                print("yes you are Customer");
                $password = $data[0]->getPassword();
                $customer_id = $data[0]->getCustomerId();
                $session->set("login", $customer_id);
                $session->set("customer_id", $customer_id);
                $layout = Mage::getBlock("core/layout");
                $url = $layout->getUrl("*/*/dashboard");
                header("location:$url");
            } else {
                $session->remove("login");
                $session->remove("customer_id");
            }
        } else {
            print("in valid credentials");
        }
    }
    public function dashboardAction()
    {
        $layout = Mage::getBlock("core/layout");


        $dashboard = $layout->createBlock("customer/account_dashboard")
            ->setTemplate("customer/dashboard.phtml");

        $layout->getChild("content")->addChild("dashboard", $dashboard);
        $customer = Mage::getSingleton("customer/session")
            ->getCustomer();
        $dashboard->setCustomer($customer);

        $profile = $layout->createBlock("customer/account_dashboard_profile");
        $layout->getChild("content")
            ->getChild("dashboard")
            ->addChild("profile", $profile);


        $order = $layout->createBlock("customer/account_dashboard_order");
        $layout->getChild("content")
            ->getChild("dashboard")
            ->addChild("order", $order);


        $address = $layout->createBlock("customer/account_dashboard_address");
        $layout->getChild("content")
            ->getChild("dashboard")
            ->addChild("address", $address);

        $layout->toHtml();
    }
    public function logoutAction()
    {
        $session = $this->getSession();
        $session->remove("login");
        $session->remove("customer_id");
        $this->redirect("customer/index/login");
    }
    public function checkEmailAction()
    {
        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');

        $request = Mage::getModel("core/request");
        $email = trim($request->getQuery("email"));

        if (!$email) {
            echo json_encode(["status" => "error", "message" => "Email is required"]);
            exit;
        }

        try {

            $loggedInCustomer = Mage::getSingleton("customer/session")->getCustomer();
            $loggedInCustomerId = $loggedInCustomer ? $loggedInCustomer->getCustomerId() : null;
            $loggedInCustomerEmail = $loggedInCustomer ? $loggedInCustomer->getEmail() : null;


            $customer = Mage::getModel("customer/customer")
                ->getCollection()
                ->addFieldToFilter("email", ["=" => $email])
                ->addFieldToFilter("customer_id", ["!=" => $loggedInCustomerId])
                ->getFirstItem();

            if ($loggedInCustomerId && $email == $loggedInCustomerEmail) {

                echo json_encode(["status" => "success", "message" => "This is your current email."]);
            } elseif ($customer->getCustomerId()) {

                echo json_encode(["status" => "error", "message" => "Email already registered!"]);
            } else {

                echo json_encode(["status" => "success", "message" => "Email available!"]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Server error: " . $e->getMessage()]);
        }
        exit;
    }
    public function forgotAction()
    {
        $layout = Mage::getBlock("core/layout");
        $forgot_pass = $layout->createBlock("customer/account_forgot")
            ->setTemplate("customer/forgot.phtml");
        $layout->getChild("content")->addChild("forgot", $forgot_pass);
        $layout->toHtml();
    }
    public function forgotPasswordAction()
    {
        $customer = Mage::getModel("customer/session")
            ->getCustomer();
        $request = Mage::getModel("core/request")->getParam("customer");
        $customer_data = $customer->load($request["email"], "email");
        if (!empty($customer_data->getData())) {
        //    $this->sendOtpAction($request["email"]);
        } else {
            print("invalid email");
        }
    }
    public function generateOtpAction()
{
    return rand(100000, 999999); // Generate 6-digit OTP
}

public function sendOtpAction()
{
    $request=Mage::getModel("core/request");
    $email=$request->getQuery("email");
    $customer = Mage::getModel("customer/session")
            ->getCustomer();
    $customer_data = $customer->load($email, "email");
    if (!empty($customer_data->getData())) {
        //    $this->sendOtpAction($request["email"]);
        
    // Generate OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + 300; // OTP valid for 5 minutes
    echo '<pre>';
    print_r($_SESSION["otp"]);
    echo '</pre>';
    $customer->setPassword(1234)
            ->save();

    // PHPMailer setup
    // $mail = new PHPMailer(true);

    // try {
    //     // SMTP Configuration
    //     $mail->isSMTP();
    //     $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'your-email@gmail.com'; // Replace with your Gmail
    //     $mail->Password = 'your-app-password'; // Use App Password (not your Gmail password)
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    //     $mail->Port = 587;

        
    //     $mail->setFrom('your-email@gmail.com', 'Your Name');
    //     $mail->addAddress($email);
    //     $mail->Subject = 'Your OTP Code';
    //     $mail->Body = "Your OTP is: $otp. This OTP is valid for 5 minutes.";

    //     if ($mail->send()) {
    //         echo "OTP sent successfully to $email";
    //     } else {
    //         echo "Failed to send OTP.";
    //     }
    // } catch (Exception $e) {
    //     echo "Mailer Error: " . $mail->ErrorInfo;
    // }
}
else{
    print("invalid");
}
}
public function verifyOtpAction()
{
    $request=Mage::getModel("core/request");
    $enteredOtp=$request->getQuery("verify_otp");
        if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry'])) {
            echo "No OTP found. Please request a new one.";
            return;
        }
        if (time() > $_SESSION['otp_expiry']) {
            echo "OTP expired. Please request a new one.";
            unset($_SESSION['otp']); // Remove expired OTP
            return;
        }
        if ($enteredOtp == $_SESSION['otp']) {
            echo "OTP verified successfully.";
            
            unset($_SESSION['otp']);
            $layout = Mage::getBlock("core/layout");
        $url = $layout->getUrl("Customer/index/login");
        header("location:$url");// Clear OTP after success
            
        } else {
            echo "Invalid OTP. Please try again.";
        }
    }
}



