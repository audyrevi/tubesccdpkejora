<?php
require_once 'LoginFormBuilder.php';

class LoginFormDirector {
    private $builder;

    public function __construct(FormBuilder $builder) {
        $this->builder = $builder;
    }

    public function buildForm() {
        $this->builder->setTitle('Aplikasi Pengelolaan Laundry');
        $this->builder->addFormAttributes('POST', 'ceklogin.php');
        $this->builder->addInput('text', 'username', 'Enter username');
        $this->builder->addInput('password', 'password', 'Enter password');
        if (isset($_GET['msg'])) {
            $this->builder->addErrorMessage($_GET['msg']);
        }
        $this->builder->addButton('Login');
        $this->builder->closeForm();
    }
}
?>
