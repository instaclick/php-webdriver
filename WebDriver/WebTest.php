<?php
/**
 * Copyright 2011 Anthon Pang. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 */

/**
 * abstract WebDriver_WebTest_Script class
 *
 * WebDriver-based web test runner, outputing results in TAP format.
 *
 * @link http://testanything.org/wiki/index.php/TAP_version_13_specification
 *
 * @package WebDriver
 */
abstract class WebDriver_WebTest_Script
{
	protected $session;
	protected $assert_stats;

	/**
	 * Constructor
	 *
	 * @param WebDriver_Session $session
	 */
	public function __construct($session)
	{
		$this->session = $session;
		$this->assert_stats = array(
			'pass' => 0,
			'failure' => 0,
			'total' => 0,
		);
	}

	/**
	 * Assert (expect) value
	 *
	 * @param mixed $expression
	 * @param mixed $expected
	 * @param string $message
	 * @throw WebDriver_Exception_WebTestAssertion if $expression is not equal to $expected
	 */
	protected function assert($expression, $expected, $message)
	{
		$this->assert_stats['total']++;

		if ($expression !== $expected)
		{
			$this->assert_stats['failure']++;
			throw WebDriver_Exception::factory(WebDriver_Exception::WebTestAssertion, $message);
		}

		$this->assert_stats['pass']++;
	}

	/**
	 * Assert (expect) exception
	 *
	 * @param mixed $expression
	 * @param string $message
	 * @throw WebDriver_Exception_WebTestAssertion if not exception is thrown
	 */
	protected function assert_exception($callback, $message)
	{
		$this->assert_stats['total']++;

		try {
			$callback();

			$this->assert_stats['failure']++;
			throw WebDriver_Exception::factory(WebDriver_Exception::WebTestAssertion, $message);
		} catch (Exception $e) {
			// expected exception
		}

		$this->assert_stats['pass']++;
	}
}

/**
 * WebDriver_WebTest class - test runner
 *
 * @package WebDriver
 */
class WebDriver_WebTest
{
	private static $magicMethods = array(
		'__construct',
		'__destruct',
		'__call',
		'__callStatic',
		'__get',
		'__set',
		'__isset',
		'__unset',
		'__sleep',
		'__wakeup',
		'__toString',
		'__invoke',
		'__set_state',
		'__clone',
	);

	/**
	 * Error handler to instead throw exceptions
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 * @throws ErrorException
	 */
	static public function exception_error_handler($errno, $errstr, $errfile, $errline )
	{
		throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
	}

	/**
	 * Assertion handler to instead throw exceptions
	 *
	 * @param string $file
	 * @param int $line
	 * @param string $code
	 * @throws ErrorException
	 */
	static public function assert_handler($file, $line, $code)
	{
		throw WebDriver_Exception::factory(WebDriver_Exception::WebTestAssertion, "assertion failed: $file:$line: $code");
	}

	/**
	 * Get classes declared in the target file
	 *
	 * @param string $file
	 * @return array Array of class names
	 */
	public function getClasses($file)
	{
		$classes = get_declared_classes();
		include_once($file);
		return array_diff(get_declared_classes(), $classes);
	}

	/**
	 * Dump comment block
	 *
	 * Note: Reflection extension expects phpdocs style comments
	 *
	 * @param string $comment
	 */
	public function dumpComment($comment)
	{
		if ($comment)
		{
			$lines = explode("\n", trim($comment));
			$lines = preg_replace(
				array('~^\s*/[*]+\s*~', '~^\s*[*]+/?\s*~'),
				'# ',
				$lines
			);
			echo implode("\n", $lines) . "\n";
		}
	}

	/**
	 * Dump diagnostic block (YAML format)
	 *
	 * @param mixed $diagnostic
	 */
	public function dumpDiagnostic($diagnostic)
	{
		if ($diagnostic)
		{
			if (function_exists('yaml_emit'))
			{
				$diagnostic = trim(yaml_emit($diagnostic));
			}
			else
			{
				$diagnostic = "---\n" . trim($diagnostic) . "\n...";
			}

			if (is_string($diagnostic))
			{
				$lines = explode("\n", $diagnostic);
				$lines = preg_replace('/^/', '  ', $lines);
				echo implode("\n", $lines) . "\n";
			}
		}
	}

	/**
	 * Parse TODO/SKIP directives (if any) from comment block
	 *
	 * @param string $comment
	 * @return string|null
	 */
	public function getDirective($comment)
	{
		if ($comment)
		{
			if (preg_match('~\b(SKIP|TODO)(\s+([\S \t]+))?~', $comment, $matches))
			{
				return $matches[0];
			}
		}

		return null;
	}

	/**
	 * Is this a testable method?
	 *
	 * @param string $className
	 * @param RefelectionMethod $reflectionMethod
	 * @return bool False if method should not be counted
	 */
	protected function isTestableMethod($className, $reflectionMethod)
	{
		$method = $reflectionMethod->getName();
		$modifiers = $reflectionMethod->getModifiers();

		if ($method === $className
			|| $modifiers !== ReflectionMethod::IS_PUBLIC
			|| in_array($method, self::$magicMethods))
		{
			return false;
		}

		return true;
	}

	/**
	 * Run tests
	 *
	 * @param string $file
	 * @return bool True if success; false otherwise
	 */
	public function runTests($file)
	{
		$success = true;

		$webdriver = new WebDriver();
		$session = $webdriver->session();

		$classes = $this->getClasses($file);

		/*
		 * count the number of testable methods
		 */
		$totalMethods = 0;
		foreach ($classes as $class)
		{
			$parents = class_parents($class, false);
			if ($parents && in_array('WebDriver_WebTest_Script', $parents))
			{
				$reflectionClass = new ReflectionClass($class);
				$reflectionMethods = $reflectionClass->getMethods();
				foreach ($reflectionMethods as $reflectionMethod)
				{
					if ($this->isTestableMethod($class, $reflectionMethod))
					{
						$totalMethods++;
					}
				}
			}
		}

		if ($totalMethods)
		{
			$i = 0;
			echo "1..$totalMethods\n";
			foreach ($classes as $class)
			{
				$parents = class_parents($class, false);
				if ($parents && in_array('WebDriver_WebTest_Script', $parents))
				{
					// the object under test
					$objectUnderTest = new $class($session);

					$reflectionClass = new ReflectionClass($class);

					$comment = $reflectionClass->getDocComment();
					$this->dumpComment($comment);

					$reflectionMethods = $reflectionClass->getMethods();
					foreach ($reflectionMethods as $reflectionMethod)
					{
						if (!$this->isTestableMethod($class, $reflectionMethod))
						{
							continue;
						}

						$i++;

						$comment = $reflectionMethod->getDocComment();
						$this->dumpComment($comment);

						$directive = $this->getDirective($comment);

						$description = $method;
						$reflectionParameters = $reflectionMethod->getParameters();
						foreach ($reflectionParameters as $reflectionParameter)
						{
							if ($reflectionParameter->getName() == 'description'
								&& $reflectionParameter->isDefaultValueAvailable())
							{
								$defaultValue = $reflectionParameter->getDefaultValue();
								if (is_string($defaultValue))
								{
									$description = $defaultValue;
									break;
								}
							}
						}

						$diagnostic = null;
						$rc = false;
						try {
							$objectUnderTest->$method();
							$rc = true;
						} catch (WebDriver_Exception_Curl $e) {
							$success = false;
							echo 'Bail out! ' . $e->getMessage() . "\n";
							break 2;
						} catch (Exception $e) {
							$success = false;
							$diagnostic = $e->getMessage();

							// @todo check driver capability for screenshot

							$screenshot = $session->screenshot();
							if (!empty($screenshot))
							{
								$imageName = basename($file) . ".$i.png";
								file_put_contents($imageName, base64_decode($screenshot));
							}
						}

						echo ($rc ? 'ok' : 'not ok') . " $i - $description" . ($directive ? " # $directive" : '') . "\n";

						$this->dumpDiagnostic($diagnostic);
					}

					unset($objectUnderTest);
				}
			}
		}
		else
		{
			echo "0..0\n";
		}

		if ($session)
		{
			$session->close();
		}

		return $success;
	}

	/**
	 * Main dispatch routine
	 *
	 * @param int $argc number of arguments
	 * @param array $argv arguments
	 * @return bool True if success; false otherwise
	 */
	static public function main($argc, $argv)
	{
		set_error_handler(array('WebDriver_WebTest', 'exception_error_handler'));

		assert_options(ASSERT_ACTIVE, 1);
		assert_options(ASSERT_WARNING, 0);
		assert_options(ASSERT_CALLBACK, array('WebDriver_WebTest', 'assert_handler'));

		/*
		 * parse command line options
		 */
		if ($argc == 1)
		{
			$argc++;
			array_push($argv, '-h');
		}

		for ($i = 1; $i < $argc; $i++)
		{
			$opt = $argv[$i];
			$optValue = '';

			if (preg_match('~([-]+[^=]+)=(.+)~', $opt, $matches))
			{
				$opt = $matches[1];
				$optValue = $matches[2];
			}

			switch ($opt)
			{
				case '-h':
				case '--help':
					echo $argv[0] . " [-d directory] [--tap] [--xml] [--disable-screenshot] test.php\n";
					exit(1);

				case '-d':
				case '--output-directory':

				case '--format':
				case '--tap':
				case '--xml':

				case '--disable-screenshot':

				default:
			}
		}

		echo "TAP version 13\n";

		$success = false;
		try {
			$webtest = new self;
			$success = $webtest->runTests($argv[1]);
		} catch (Exception $e) {
			echo 'Bail out! ' . $e->getMessage() . "\n";
		}

		return $success;
	}
}
