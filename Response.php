<?php
class Response implements JsonSerializable
    {
        protected $result;
        protected $message;

        public function __construct($result, $message) 
        {
            $this->result=$result;
            $this->message=$message;
        }
        public function jsonSerialize() 
        {
            return [
                'result' => $this->result,
                'message' => $this->message,
            ];
        }
    }
?>