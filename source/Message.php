<?php

namespace Source;

class Message
{
    private $text;

    private $type;

    private $before;

    private $after;


    public function __toString()
    {
        return $this->render();
    }

    public function getText(): ?string
    {
        return $this->before . $this->text . $this->after;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function before(string $text): Message
    {
        $this->before = $text;
        return $this;
    }

    public function after(string $text): Message
    {
        $this->after = $text;
        return $this;
    }

    public function info(string $message): Message
    {
        $this->type = "info";
        $this->text = $this->filter($message);
        return $this;
    }

    public function success(string $message): Message
    {
        $this->type = "success";
        $this->text = $this->filter($message);
        return $this;
    }

    public function warning(string $message): Message
    {
        $this->type = "warning";
        $this->text = $this->filter($message);
        return $this;
    }

    public function error(string $message): Message
    {
        $this->type = "error";
        $this->text = $this->filter($message);
        return $this;
    }

    public function render(): string
    {
        return "<div class='message {$this->getType()}'>{$this->getText()}</div>";
    }

    private function filter(string $message): string
    {
        return filter_var($message, FILTER_SANITIZE_STRIPPED);
    }
}