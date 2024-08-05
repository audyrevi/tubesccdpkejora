<?php
require_once 'FormBuilder.php';

class LoginFormBuilder implements FormBuilder {
    private $html;

    public function __construct() {
        $this->html = '';
    }

    public function setTitle(string $title): void {
        $this->html .= "<div class=\"login100-form-title\" style=\"background-image: url(assets/login/images/bg-01.jpg);\">\n";
        $this->html .= "<span class=\"login100-form-title-1\">\n";
        $this->html .= $title . "\n";
        $this->html .= "</span>\n";
        $this->html .= "</div>\n";
    }

    public function addFormAttributes(string $method, string $action): void {
        $this->html .= "<form class=\"login100-form validate-form\" method=\"$method\" action=\"$action\">\n";
    }

    public function addInput(string $type, string $name, string $placeholder): void {
        $this->html .= "<div class=\"wrap-input100 validate-input m-b-26\" data-validate=\"$placeholder is required\">\n";
        $this->html .= "<span class=\"label-input100\">" . ucfirst($name) . "</span>\n";
        $this->html .= "<input class=\"input100\" type=\"$type\" name=\"$name\" placeholder=\"$placeholder\">\n";
        $this->html .= "<span class=\"focus-input100\"></span>\n";
        $this->html .= "</div>\n";
    }

    public function addButton(string $text): void {
        $this->html .= "<div class=\"container-login100-form-btn\">\n";
        $this->html .= "<button class=\"login100-form-btn\" type=\"submit\">\n";
        $this->html .= $text . "\n";
        $this->html .= "</button>\n";
        $this->html .= "</div>\n";
    }

    public function addErrorMessage(string $message): void {
        $this->html .= "<small class=\"text-danger\">" . htmlspecialchars($message) . "</small>\n";
    }

    public function closeForm(): void {
        $this->html .= "</form>\n";
    }

    public function getResult(): string {
        return $this->html;
    }
}
?>
