<?php

namespace app\core;

class Application
{

    public string $layout = 'auth';
    public static string $ROOT_DIR;
    public string $technicianClass;
    public string $serviceCenterClass;
    public static Application $app;
    public string $customerClass;
    public string $adminClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public ?DbModel $technician;

    public Controller $controller;
    public ?DbModel $customer;
    public ?DbModel $serviceCenter;
    public ?DbModel $admin;

    public function __construct($rootPath, array $config)
    {
        $this->customerClass = $config['customerClass'];
        $this->technicianClass = $config['technicianClass'];
        $this->serviceCenterClass = $config['serviceCenterClass'];
        $this->adminClass = $config['adminClass'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $this->db = new Database($config['db']);


        $primaryValueTechnician = $this->session->get('technician');
        if ($primaryValueTechnician) {
            $technicianInstance = new $this->technicianClass;
            $primaryKey = $technicianInstance->primaryKey();
            $this->technician = $technicianInstance->findOne([$primaryKey => $primaryValueTechnician]);
        } else {
            $this->technician = null;
        }

        $primaryValueCustomer = $this->session->get('customer');
        if ($primaryValueCustomer) {
            $customerInstance = new $this->customerClass;
            $primaryKey = $customerInstance->primaryKey();
            $this->customer = $customerInstance->findOne([$primaryKey => $primaryValueCustomer]);
        } else {
            $this->customer = null;
        }


        $primaryValueServiceCentre = $this->session->get('serviceCenter');

        if ($primaryValueServiceCentre) {
            $serviceCenterInstance = new $this->serviceCenterClass;
            $primaryKey = $serviceCenterInstance->primaryKey();
            $this->serviceCenter = $serviceCenterInstance->findOne([$primaryKey => $primaryValueServiceCentre]);
        } else {
            $this->serviceCenter = null;
        }

        $primaryValueAdmin = $this->session->get('admin');
        if ($primaryValueAdmin) {
            $adminInstance = new $this->adminClass;
            $primaryKey = $adminInstance->primaryKey();
            $this->admin = $adminInstance->findOne([$primaryKey => $primaryValueAdmin]);
        } else {
            $this->admin = null;
        }
    }

    public function loginCustomer(DbModel $customer)
    {
        $this->customer = $customer;
        $primaryKey = $customer->primaryKey();
        $primaryValue = $customer->{$primaryKey};
        $this->session->set('customer', $primaryValue);
        return true;
    }

    public function logoutCustomer()
    {
        $this->customer = null;
        $this->session->remove('customer');
    }

    public static function isGuestCustomer()
    {
        return !self::$app->customer;
    }

    public function run()
    {
        echo $this->router->resolve();
    }

    public static function isGuestTechnician()
    {
        return !self::$app->technician;
    }

    public function loginTechnician(DbModel $technician)
    {
        $this->technician = $technician;
        $primaryKey = $technician->primaryKey();
        $primaryValue = $technician->{$primaryKey};
        $this->session->set('technician', $primaryValue);
        return true;
    }


    public function logoutTechnician()
    {
        $this->technician = null;
        $this->session->remove('technician');
    }

    public static function isGuestServiceCenter()
    {
        return !self::$app->serviceCenter;
    }

    public function loginServiceCenter(DbModel $serviceCenter)
    {
        $this->serviceCenter = $serviceCenter;
        $primaryKey = $serviceCenter->primaryKey();
        $primaryValue = $serviceCenter->{$primaryKey};
        $this->session->set('serviceCenter', $primaryValue);
        return true;
    }

    public function logoutServiceCenter()
    {
        $this->serviceCenter = null;
        $this->session->remove('serviceCenter');
    }

    public function loginAdmin(DbModel $admin)
    {
        $this->admin = $admin;
        $primaryKey = $admin->primaryKey();
        $primaryValue = $admin->{$primaryKey};
        $this->session->set('admin', $primaryValue);
        return true;
    }

    public function logoutAdmin()
    {
        $this->admin = null;
        $this->session->remove('admin');
    }

}
