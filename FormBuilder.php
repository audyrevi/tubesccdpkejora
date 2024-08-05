<?php
interface FormBuilder {
    public function setTitle(string $title): void;
    public function addInput(string $type, string $name, string $placeholder): void;
    public function addButton(string $text): void;
    public function addErrorMessage(string $message): void;
    public function getResult(): string;
}
?>
