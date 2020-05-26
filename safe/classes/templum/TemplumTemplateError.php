<?php
namespace Templum;
/**
 * @brief TemplumTemplate errors.
 *
 * This exception is thrown by the TemplumTemplate class when errors occur
 * during the execution of templates. PHP errors, warnings and notices that
 * occur during the template execution are captured by the TemplumTemplate class and
 * are thrown as TemplumTemplateError exceptions.
 */
class TemplumTemplateError extends Exception {

	protected $template = NULL; /**< The TemplumTemplate instance causing the error. */

	/**
	 * @brief Create a new TemplumTemplateError instance
	 * @param $message (string) The error message.
	 * @param $code (int) The error code
	 * @param $template (TemplumTemplate) The template containing the error.
	 */
	public function __construct($message, $code = 0, $template = NULL) {
		$this->template = $template;
		parent::__construct($message, $code);
	}

	/**
	 * @brief Return the TemplumTemplate instance that contains the error.
	 * @return (TemplumTemplate) The template containing the error or NULL if not available.
	 */
	public function getTemplate() {
		return($this->template);
	}

}