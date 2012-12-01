<?php

namespace XCore\Kernel;

/**
 * This class manages resources of each languages. By requests of other
 * components, this class loads files, or checks the existence of the specified
 * resource, or composes file path to access real files. And, it manages some
 * locale information.
 *
 * Rules about language are different at each bases. So it's important that a
 * base defines the sub class of this class if it can't use this class directly.
 *
 * And, XCube or bases have to make each languages possible to have its sub
 * class. By that, languages become able to implement their logic to solve
 * problems.
 *
 * This class calls sub directories of each languages 'section'. 'section' is
 * used to load image files and etc.
 */
class LanguageManager
{
	/**
	 * @access protected
	 * @var string
	 * @todo 他のクラスが参照しているため protected にできない: getLanguage() を使わせる
	 */
	public $mLanguageName;

	/**
	 * @var string
	 */
	protected $mLocaleName;

	/**
	 * Return new LanguageManager instance
	 */
	public function __construct()
	{
		$this->mLanguageName = $this->getFallbackLanguage();
		$this->mLocaleName = $this->getFallbackLocale();
	}

	/**
	 * Normally, this member function is called soon, after constructor.
	 * To follow the base, initialize.
	 */
	public function prepare()
	{
	}

	/**
	 * Set locale name.
	 * @param string $locale locale name
	 */
	public function setLocale($locale)
	{
		$this->mLanguageName = $locale; // @todo これはバグでは？ mLocaleName の間違い?
	}

	/**
	 * Get locale name.
	 * @return string  locale name
	 */
	public function getLocale()
	{
		return $this->mLanguageName; // @todo これはバグでは？ mLocaleName の間違い?
	}

	/**
	 * Set language name.
	 * @param string $language language name
	 */
	public function setLanguage($language)
	{
		$this->mLanguageName = $language;
	}

	/**
	 * Get language name.
	 * @return string  language name
	 */
	public function getLanguage()
	{
		return $this->mLanguageName;
	}

	/**
	 * Load the global message catalog which is defined in the base module.
	 */
	public function loadGlobalMessageCatalog()
	{
	}

	/**
	 * Load the module message catalog which is defined in the specified module.
	 * @param string $moduleName A name of module.
	 */
	public function loadModuleMessageCatalog($moduleName)
	{
	}

	/**
	 * Load the theme message catalog which is defined in the specified module.
	 * @param string $themeName A name of theme.
	 */
	public function loadThemeMessageCatalog($themeName)
	{
	}

	/**
	 * check the existence of the specified file in the specified section.
	 * @param string $section  A name of section.
	 * @param string $filename A name of file
	 * @return bool
	 */
	public function existFile($section, $filename)
	{
	}

	/**
	 * Return the file path by the specified section and the specified file.
	 * @param string $section  A name of section.
	 * @param string $filename A name of file
	 * @return string
	 */
	public function getFilepath($section, $filename)
	{
	}

	/**
	 * Get file contents and return it.
	 * @param string $section  A name of section.
	 * @param string $filename A name of file
	 * @return string
	 */
	public function loadTextFile($section, $filename)
	{
	}

	/**
	 * Return translated message.
	 * @param  string $word
	 * @return string
	 * @note This member function is test.
	 */
	public function translate($word)
	{
		return $word;
	}

	/**
	 * Return default language name.
	 * @return string
	 */
	protected function getFallbackLanguage()
	{
		return "eng";
	}

	/**
	 * Return default locale name.
	 * @return string
	 */
	protected function getFallbackLocale()
	{
		return "EG";
	}

	public function encodeUTF8($str)
	{
		return $str;
	}

	public function decodeUTF8($str)
	{
		return $str;
	}
}
