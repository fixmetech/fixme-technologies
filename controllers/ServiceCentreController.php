<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Post;
use app\models\ServiceCenter;
use app\models\Technician;

class ServiceCentreController extends Controller
{
    public function serviceCentreLanding()
    {
        $this->setLayout('auth');
        return $this->render('/service-centre-landing');
    }

    public function serviceCentreDashboard()
    {
        $this->setLayout('auth');
        return $this->render('/service-centre/service-centre-dashboard');
    }

    public function serviceCentreSignup()
    {
        $this->setLayout('auth');
        return $this->render('/service-centre-sign-up');
    }

    public function serviceCentreLogin()
    {
        $this->setLayout('auth');
        return $this->render('/service-centre-login');
    }

    public function serviceCentreMap()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/service-centre-map');
    }

    public function serviceCentreHome()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/service-centre-home');
    }

    public function serviceCentreSettings()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/service-centre-settings');
    }

    public function serviceCentreProfile()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/service-centre-profile');
    }

    public function updateServiceCenter(Request $request)
    {
        $serviceCenter = new ServiceCenter();

        if ($request->isPost()) {
            $serviceCenter->loadData($request->getBody());
            if ($serviceCenter->updateValidate()) {
                $serviceCenter->updateServiceCenter();
                Application::$app->session->setFlash('update-success', 'Update is successful');
                Application::$app->response->redirect('/service-centre-profile');
            } else {
                Application::$app->session->setFlash('update-error', 'Update is failed');
                Application::$app->response->redirect('/service-centre-profile');
            }
        }
    }

    public function serviceCenterHelp()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/service-center-help');
    }

    public function serviceCenterCommunity()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/service-center-community');
    }

    public function marketPlaceHome()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/market-place-home');
    }

    public function checkOutPage()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/check-out-page');
    }

    public function cardDetails()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/card-details');
    }

    public function serviceCenterCreateProduct()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/create-product');
    }

    public function update()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/update-product');
    }

    public function serviceCenterMessages()
    {
        $this->setLayout('auth');
        return $this->render('/service-centre/service-center-messages');
    }

    public function cart()
    {
        $this->setLayout('auth');
        return $this->render('/service-centre/view-cart');
    }

    public function viewServiceCenterProfile($id)
    {

        // echo json_encode($id);
        // $id is an array, we need only the first element of that array
        $serviceCenter = (new ServiceCenter())->findById(intval($id[0]));
        $this->setLayout('auth');
        if (!$serviceCenter) {
            return $this->render('_404');
        }
//        show($serviceCenter['name']);

        return $this->render('/customer/service-center-profile', [
            'serviceCenter' => $serviceCenter,
        ]);
    }

    public function serviceCenterPaymentDetails()
    {
        $this->setLayout('auth');
        return $this->render('service-centre/service-center-payment-details');
    }

}