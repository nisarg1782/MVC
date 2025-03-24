<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
        $layout = $this->getLayout();
        $registration = $layout->createBlock("customer/account_register")
            ->setTemplate("customer/register.phtml");
        $layout->getChild("content")
            ->addChild("registration", $registration);
        $layout->toHtml();
    }
    public function loginAction()
    {
        $layout = $this->getLayout();
        $registration = $layout->createBlock("customer/account_login")
            ->setTemplate("customer/login.phtml");
        $layout->getChild("content")
            ->addChild("login", $registration);
        $layout->toHtml();
    }
    public function registerCustomerAction()
    {
        $layout = $this->getLayout();
        $customer = $this->getRequest()->getParam("customer");

        $customer = Mage::getSingleton("customer/session")
            ->getCustomer()
            ->setData($customer)
            ->Save();

        $layout = $this->getLayout();
        $this->redirect("Customer/index/login");
        // header("location:$url");
    }
    public function loginCustomerAction()
    {
        $login_data = $this->getRequest()->getParam("customer");
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
                $session->set("customer_id", $customer_id);
                // $session->set("customer_id", $customer_id);
                // $layout = Mage::getBlock("core/layout");
                $this->redirect("customer/index/dashboard");
                // header("location:$url");
            } else {
                // $session->remove("login");
                $session->remove("customer_id");
            }
        } else {
            print("in valid credentials");
        }
    }
    public function dashboardAction()
    {
        $layout = $this->getLayout();


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
        $session->remove("customer_id");
        // $session->remove("customer_id");
        $this->redirect("customer/index/login");
    }
    public function checkEmailAction()
    {
        header('Content-Type: application/json; charset=UTF-8');
        header('Access-Control-Allow-Origin: *');

        $request = $this->getRequest();
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
        $layout = $this->getLayout();
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
    public function generatePassword($length = 10)
    {
        return substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()', $length)), 0, $length);
    }


    public function sendOtpAction()
    {
        $request = $this->getRequest();
        $email = $request->getQuery("email");
        $customer = Mage::getModel("customer/session")
            ->getCustomer();
        $customer_data = $customer->load($email, "email");
        if (!empty($customer_data->getData())) {
            //    $this->sendOtpAction($request["email"]);

            // Generate OTP
            $password = $this->generatePassword(10);
            $_SESSION['password'] = $password;
            $_SESSION['password_expiry'] = time() + 300; // OTP valid for 5 minutes
            // echo '<pre>';
            // print_r($_SESSION["otp"]);
            // echo '</pre>';
            $customer->setPassword($password)
                ->save();

            // PHPMailer setup
            $mail = new PHPMailer(true);

            try {
                // SMTP Configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'nisargt1782@gmail.com'; // Replace with your Gmail
                $mail->Password = 'donx nmyy wgel mduk'; // Use App Password (not your Gmail password)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;


                $mail->setFrom('nisargt1782@gmail.com', 'hello ');
                $mail->addAddress($email);
                $mail->Subject = 'Your temporary password is ';
                $mail->Body = "Your temporary password  is: $password. This is valid for 5 minutes.";

                if ($mail->send()) {
                    echo "password sent successfully to $email";
                    $this->redirect("customer/index/login");
                } else {
                    echo "Failed to send password.";
                }
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            print("invalid");
        }
    }
}
