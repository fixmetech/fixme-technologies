<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Admin;
use app\models\Customer;
use app\models\Promotion;
use app\models\Technician;
use app\models\ServiceCenter;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        // Fetch counts for technicians, customers, and service centers
        $counts = Admin::countEntities();

        $requestfromUsers = Admin::requestsFromUser();

        // Set the layout and render the dashboard with counts
        $this->setLayout('header');
        return $this->render('/admin/admin-dashboard');
    }

    public function manageUsers()
    {
        $this->setLayout('auth');
        return $this->render('/admin/users');
    }

    public function adminSettings()
    {
        $this->setLayout('header');
        return $this->render('/admin/admin-settings');
    }

    public function adminProfile()

    {
        $this->setLayout('auth');
        return $this->render('/admin/admin-profile');
    }

    public function updateAdminProfile(Request $request)
    {
        $admin = new Admin();
        if ($request->isPost()) {
            $admin->loadData($request->getBody());
            if ($admin->updateValidate()) {
                $admin->updateAdmin();
                Application::$app->session->setFlash('update-success', 'You have been Updated your account info successfully!');
                Application::$app->response->redirect('/admin-profile');
            } else {
                Application::$app->response->redirect('/admin-profile');
            }
        }
    }

    public function viewReports()
    {
        $this->setLayout('header');
        return $this->render('/admin/reports');
    }

    public function manageServices()
    {
        $this->setLayout('auth');
        return $this->render('/admin/services');
    }

    public function adminLogin()
    {
        $this->setLayout('auth');
        return $this->render('/admin/admin-login.php');
    }


    public function promotions()
    {
        $this->setLayout('header');
        $promotions = Promotion::getAllPromotions();
        return $this->render('/admin/admin-promotions', [
            'promotions' => $promotions
        ]);
    }

    public function insert_promotion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $desc = $_POST['promdesc'];
            $price = $_POST['price'];
            $create = $_POST['strdate'];
            $update = $_POST['enddate'];

            $success = Promotion::insert_promotion($desc, $create, $price, $update);

            if ($success) {
                header('Location:/admin-promotions');
            }


        }
    }

    public function update_promotion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            print_r($_POST);
            $desc = $_POST['promdesc'];
            $price = $_POST['price'];
            $update = $_POST['enddate'];
            $id = $_POST['promid'];
            $success = Promotion::updatePromotion($id, $desc, $price, $update);

            if ($success) {
                header('Location:/admin-promotions');
            }


        }
    }

    public function delete_promotion()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_POST['promid'];
            $success = Promotion::deletePromotion($id);

            if ($success) {
                header('Location:/admin-promotions');
            }


        }
    }


    public function customers()
    {
        // Fetch all customers records
        $customers = Admin::findAllCustomers();
        // Render the all the customer in the database
        $this->setLayout('header');
        return $this->render('/admin/customers', ['customers' => $customers]);

    }

    public function technicians()
    {
        // Fetch all technicians records
        $technicians = Admin::findAllTechnicians();
        // Render the all the customer in the database
        $this->setLayout('header');
        return $this->render('/admin/technicians', ['technicians' => $technicians]);

    }
    public function serviceCenters()
    {
        // Fetch all service centers records
        $serviceCenters = Admin::findAllServiceCenters();
        // Render the all the customer in the database
        $this->setLayout('header');
        return $this->render('/admin/admin-service-center', ['serviceCenters' => $serviceCenters]);

    }
    
    public function changeCustomerStatus(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $cus_id = $data['cus_id'] ?? null;
        $status = $data['status'] ?? null;

        if ($cus_id && $status) {
            $result = Admin::updateCustomerStatus($cus_id, $status); // Call the method to update the status
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Customer status updated successfully.']);
                return;
            }
        }

        echo json_encode(['status' => 'error', 'message' => 'Failed to update customer status.']);
    }

    public function changeTechnicianStatus(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $tech_id = $data['tech_id'] ?? null;
        $status = $data['status'] ?? null;

        if ($tech_id && $status) {
            $result = Admin::updateTechnicianStatus($tech_id, $status); // Call the method to update the status
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Technician status updated successfully.']);
                return;
            }
        }

        echo json_encode(['status' => 'error', 'message' => 'Failed to update technician status.']);
    }

}
    

    

   