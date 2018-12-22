<?php
/**
 * @brief Templum errors.
 * 
 * This exception is thrown by the Templum class when errors occur
 * during instantiation or when loading and parsing templates.
 */
class TemplumError extends Exception {

	/**
	 * @brief Create a new TemplumError instance
	 * @param $message (string) The error message.
	 * @param $code (int) The error code
	 */
	public function __construct($message, $code = 0) {
		parent::__construct($message, $code);
	}

}