<?php
namespace Templum;
/*
 *
 * The MIT License
 *
 * Copyright (c) 2009, ZX, Ferry Boender
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
*/

/**
* Changes by TIGREZ / Luc Geritz
* - each class in its own file (to allow autoloading)
* - changed php4-type constructors to __construct() for php7 compatibility
*/

/**
 * @brief Templum Templating Engine.
 *
 * This is the main Templum class. It takes care of retrieval, caching and
 * compiling of (translated) templates.
 */
class Templum {

	private const TEMPLUM_VERSION = "0.4.0";

	/**
	 * @brief Create a new Templum instance.
	 * @param $templatePath (string) The full or relative path to the template directory.
	 * @param $varsUniversal (array) An array of key/value pairs that will be exported to every template retrieved using this template engine instance.
	 * @param $locale (string) The locale for the templates to retrieve. If a file with the suffix noted in $locale is available, it will be returned instead of the default .tpl file.
	 * @throw TemplumError if the $templatePath can't be found or isn't a directory.
	 */
	public function __construct($templatePath, $varsUniversal = array(), $locale = NULL) {
        if (!file_exists($templatePath)) {
			throw new TemplumError("No such file or directory: $templatePath", 1);
		}
		if (!is_dir($templatePath)) {
			throw new TemplumError("Not a directory: $templatePath", 2);
		}
		$this->templatePath = rtrim(realpath($templatePath), '/');
		$this->varsUniversal = $varsUniversal;
		$this->locale = $locale;
		$this->autoEscape = True;
		$this->cache = array();
	}

	/**
	 * @brief Set a universal variable which will available in each template created with this Templum instance.
	 * @param $varName (string) The name of the variable. This will become available in the template as $VARNAME.
	 * @param $varValue (mixed) The value of the variable.
	 */
	public function setVar($varName, $varValue, $makeScalar = false) {
		$this->varsUniversal[$varName] = $varValue;
	}

	/**
	 * @brief Turn the auto escape on or off. If on, all content rendered using {{ and }} will automatically be escaped with htmlspecialchars().
	 * @param $escape (boolean) True of False. If True, auto escaping is turned on (this is the default). If False, it is turned off for templates retrieved with this Templum engine.
	 * @note Auto escaping can be overridden by passing the $autoEscape option to the template() and templateFromString() methods.
	 */
	public function setAutoEscape($escape = True) {
		$this->autoEscape = $escape;
	}

	/**
	 * @brief Set the locale for templates.
	 * @param $locale (string) The locale for the templates to retrieve. If a file with the suffix noted in $locale is available, it will be returned instead of the default .tpl file.
	 */
	public function setLocale($locale) {
		$this->locale = $locale;
	}

	/**
	 * @brief Retrieve a template by from disk (caching it in memory for the duration of the Templum instance lifetime) or from cache.
	 * @param $path (string) TemplumTemplate path, without the .tpl extension, relative to the templatePath.
	 * @param $varsGlobal (array) Array of key/value pairs that will be exported to the returned template and all templates included by that template.
	 * @param $autoEscape (boolean) Whether to auto escape {{ and }} output with htmlspecialchars()
	 * @throw TemplumError if the template couldn't be read.
	 */
	public function template($path, $varsGlobal = array(), $autoEscape = NULL) {
		$fpath = $this->templatePath . '/' . trim($path, '/').'.tpl';
		if ($autoEscape === NULL) {
			$autoEscape = $this->autoEscape;
		}

		// Check for translated version of this template.
		if (!empty($this->locale)) {
			// Check if the translated template exists in the cache. If it
			// does, returned the cached result. Otherwise check the disk for
			// the translated template.
			$fpathTrans = realpath($fpath.'.'.$this->locale);
			if ($fpathTrans !== False) {
				if (array_key_exists($fpathTrans, $this->cache)) {
					return($this->cache[$fpathTrans]);
				} else {
					if (file_exists($fpathTrans)) {
						$fpath = $fpathTrans;
					}
				}
			}
		// Check the non-translated version of this template
		} else {
			// Check the cache for the non-translated template.
			$rpath = realpath($fpath);
			if($rpath === False) {
				throw new TemplumError("Template not found or not a file: $fpath", 3);
			}
			if (array_key_exists($rpath, $this->cache)) {
				return($this->cache[$rpath]);
			}
			$fpath = $rpath;
		}

		// Check if the template exists.
		if (!is_file($fpath)) {
			throw new TemplumError("Template not found or not a file: $fpath", 3);
		}
		if (!is_readable($fpath)) {
			throw new TemplumError("Template not readable: $fpath", 4);
		}

		// Load the base or translated template.
		$template = new TemplumTemplate(
				$this,
				$fpath,
				$this->compile(file_get_contents($fpath), $autoEscape),
				array_merge($this->varsUniversal, $varsGlobal)
			);
		$this->cache[$fpath] = $template;
		return($template);
	}

	/**
	 * @brief Create a TemplumTemplate from a string.
	 *
	 * Create a TemplumTemplate instance using $contents as the template contents.
	 * This severely limited what you can do with the TemplumTemplate. There will be
	 * no including from the template, no translations, no caching, etc.
	 *
	 * @param $contents (string) The template contents.
	 * @param $autoEscape (boolean) Whether to auto escape {{ and }} output with htmlspecialchars()
	 * @returns (TemplumTemplate) TemplumTemplate class instance.
	 */
	public static function templateFromString($contents, $autoEscape = Null) {
		if ($autoEscape === Null) {
			$autoEscape = $this->autoEscape;
		}

		// Load the base or translated template.
		$template = new TemplumTemplate(
				NULL,
				"FROM_STRING",
				$this->compile($contents, $autoEscape),
				array()
			);
		return($template);
	}

	/**
	 * @brief Compile a template string to PHP code.
	 * @param $contents (string) String to compile to PHP code.
	 * @param $autoEscape (boolean) Whether to auto escape {{ and }} output with htmlspecialchars()
	 * @note This method is used by the Templum class itself, and shouldn't be called directly yourself. Use templateFromString() instead.
	 */
	private function compile($contents, $autoEscape = True) {
		// Parse custom short-hand tags to PHP code.
		$contents = preg_replace(
			array(
				"/{{/",
				"/}}\n/",
				"/}}/",
				"/\[\[/",
				"/\]\]/",
				'/^\s*@(.*)$/m',
				'/\[:\s*block\s(.*)\s*:\](.*)\[:\s*endblock\s*:\]/Usm',
				),
			array(
				$autoEscape ? "<?php echo(htmlspecialchars(" : "<?php echo(",
				$autoEscape ? ")); ?>\n\n" : "); ?>\n\n",
				$autoEscape ? ")); ?>" : "); ?>",
				"<?php ",
				" ?>",
				"<?php \\1 ?>",
				"<?php if (array_key_exists('\\1', \$this->inheritBlocks)) { print(\$this->inheritBlocks['\\1']); } else if (\$this->inheritFrom === NULL) { ?>\\2<?php } else { ob_start(); ?>\\2<?php \$this->inheritBlocks['\\1'] = ob_get_contents(); ob_end_clean(); } ?>",
				),
			$contents
		);
		return($contents);
	}
}