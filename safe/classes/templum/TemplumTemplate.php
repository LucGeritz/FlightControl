<?php
namespace Templum;

/**
 * @brief Template class
 *
 * This is the TemplumTemplate class. It represents a template and handles the
 * actual rendering of the template, as well as catching errors during
 * rendering. It also contains helper methods which can be used in templates.
 */
class TemplumTemplate {
	/**
	 * @brief Create a new TemplumTemplate instance. You'd normally get an instance from a Templum class instance.
	 * @param $templum (Templum instance) The Templum class instance that generated this TemplumTemplate instance.
	 * @param $filename (string) The filename of this template.
	 * @param $contents (string) The compiled contents of this template.
	 * @param $varsGlobal (array) An array of key/value pairs which represent the global variables for this template and the templates it includes.
	 */
	public function __construct($templum, $filename, $contents, $varsGlobal = array()) {
		$this->templum = $templum;
		$this->filename = $filename;
		$this->contents = $contents;
		$this->varsGlobal = $varsGlobal;
		$this->inheritFrom = NULL;
		$this->inheritBlocks = array();
	}

	/**
	 * @brief Add an global variable. The global variable will be available to this templates and all the templates it includes.
	 * @param $varName (string) The name of the variable.
	 * @param $varValue (mixed) The value of the variable.
	 */
	public function setVar($varName, $varValue) {
		$this->varsGlobal[$varName] = $varValue;
	}

	/**
	 * @brief Render the contents of the template and return it as a string.
	 * @param $varsLocal (array) An array of key/value pairs which represent the local variables for this template.
	 * @return (string) The rendered contents of the template.
	 */
	public function render($varsLocal = array()) {
		// Extract the Universal (embedded in global), Global and
		// Localvariables into the current scope.
		extract($this->varsGlobal);
		extract($varsLocal);

		// Start output buffering so we can capture the output of the eval.
		ob_start();

		// Temporary set the error handler so we can show the faulty template
		// file. Render the contents, reset the error handler and return the
		// rendered contents.
		$this->errorHandlerOrig = set_error_handler(array($this, 'errorHandler'));
		eval("?>" . $this->contents);
		restore_error_handler();

		// Stop output buffering and return the contents of the buffer
		// (rendered template).
		$result = ob_get_contents();
		ob_end_clean();

		if ($this->inheritFrom !== NULL) {
			$this->inheritFrom->inheritBlocks = $this->inheritBlocks;
			$result = $this->inheritFrom->render();
		}

		return($result);
	}

	/**
	 * @brief The error handler that handles errors during the parsing of the template.
	 * @param $nr (int) Error code
	 * @param $string (string) Error message
	 * @param $file (string) Filename of the file in which the erorr occurred.
	 * @param $line (int) Linenumber of the line on which the error occurred.
	 * @note Do not call this yourself. It is used internally by Templum but must be public.
	 */
	public function errorHandler($nr, $string, $file, $line) {
		// We can restore the old error handler, otherwise this error handler
		// will stay active because we throw an exception below.
		restore_error_handler();

		// If this is reached, it means we were still in Output Buffering mode.
		// Stop output buffering, or we'll end up with template text on the
		// Stdout.
		ob_end_clean();

		// Throw the exception
		throw new TemplumTemplateError("$string (file: {$this->filename}, line $line)", 1, $this);
	}

	/**
	 * @brief Include another template.
	 * @param $template (string) The template to include.
	 * @param $varsLocal (array) An array of key/value pairs which represent the local variables for this template.
	 */
	public function inc($template, $varsLocal = array()) {
		if (!isset($this->templum)) {
			throw new TemplumTemplateError("Cannot include templates in a TemplumTemplate instance created from a string.", 2, $this);
		}
		$t = $this->templum->template($template, $varsLocal);
		print($t->render());
	}

	/**
	 * @brief Inherit from a parent template.
	 * @param $template (string) The template to inherit from.
	 */
	public function inherit($template) {
		$this->inheritFrom = $this->templum->template($template);
	}
}