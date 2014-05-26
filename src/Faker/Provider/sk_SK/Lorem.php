<?php

namespace Faker\Provider\sk_SK;

class Lorem extends \Faker\Provider\Internet
{
	protected static $wordList = array(
		'výstižný', 'korekcia', 'prejesť sa', 'termika', 'introvertný', 'kmeň',
		'relevantný', 'deštruktívny', 'deštruktívny', 'nátlak', 'kaverna', 'detstvo', 'širočina',
		'dobe', 'súčasná', 'hubovita', 'východným', 'vychádzajú', 'lekár', 'uvolňoval',
		'pozorovatelného', 'vedro', 'peepis', 'navzdory', 'pacienti', 'pomerne', 'lode', 'volne', 'niektore', 'široký',
		'nervózne', 'moc', 'pozorovateľ', 'samostatná', 'dosahovať', 'základna', 'časť'
	);

	/**
	 * @example 'Lorem'
	 */
	public static function word()
	{
		return static::randomElement(static::$wordList);
	}

	/**
	 * Generate an array of random words
	 *
	 * @example array('Lorem', 'ipsum', 'dolor')
	 * @param  integer      $nb     how many words to return
	 * @param  bool         $asText if true the sentences are returned as one string
	 * @return array|string
	 */
	public static function words($nb = 3, $asText = false)
	{
		$words = array();
		for ($i=0; $i < $nb; $i++) {
			$words []= static::word();
		}

		return $asText ? join(' ', $words) : $words;
	}

	/**
	 * Generate a random sentence
	 *
	 * @example 'Lorem ipsum dolor sit amet.'
	 * @param  integer $nbWords         around how many words the sentence should contain
	 * @param  boolean $variableNbWords set to false if you want exactly $nbWords returned,
	 *                                  otherwise $nbWords may vary by +/-40% with a minimum of 1
	 * @return string
	 */
	public static function sentence($nbWords = 6, $variableNbWords = true)
	{
		if ($nbWords <= 0) {
			return '';
		}
		if ($variableNbWords) {
			$nbWords = self::randomizeNbElements($nbWords);
		}

		$words = static::words($nbWords);
		$words[0] = ucwords($words[0]);

		return join($words, ' ') . '.';
	}

	/**
	 * Generate an array of sentences
	 *
	 * @example array('Lorem ipsum dolor sit amet.', 'Consectetur adipisicing eli.')
	 * @param  integer      $nb     how many sentences to return
	 * @param  bool         $asText if true the sentences are returned as one string
	 * @return array|string
	 */
	public static function sentences($nb = 3, $asText = false)
	{
		$sentences = array();
		for ($i=0; $i < $nb; $i++) {
			$sentences []= static::sentence();
		}

		return $asText ? join(' ', $sentences) : $sentences;
	}

	/**
	 * Generate a single paragraph
	 *
	 * @example 'Sapiente sunt omnis. Ut pariatur ad autem ducimus et. Voluptas rem voluptas sint modi dolorem amet.'
	 * @param  integer $nbSentences         around how many sentences the paragraph should contain
	 * @param  boolean $variableNbSentences set to false if you want exactly $nbSentences returned,
	 *                                      otherwise $nbSentences may vary by +/-40% with a minimum of 1
	 * @return string
	 */
	public static function paragraph($nbSentences = 3, $variableNbSentences = true)
	{
		if ($nbSentences <= 0) {
			return '';
		}
		if ($variableNbSentences) {
			$nbSentences = self::randomizeNbElements($nbSentences);
		}

		return join(static::sentences($nbSentences), ' ');
	}

	/**
	 * Generate an array of paragraphs
	 *
	 * @example array($paragraph1, $paragraph2, $paragraph3)
	 * @param  integer      $nb     how many paragraphs to return
	 * @param  bool         $asText if true the paragraphs are returned as one string, separated by two newlines
	 * @return array|string
	 */
	public static function paragraphs($nb = 3, $asText = false)
	{
		$paragraphs = array();
		for ($i=0; $i < $nb; $i++) {
			$paragraphs []= static::paragraph();
		}

		return $asText ? join("\n\n", $paragraphs) : $paragraphs;
	}

	/**
	 * Generate a text string.
	 * Depending on the $maxNbChars, returns a string made of words, sentences, or paragraphs.
	 *
	 * @example 'Sapiente sunt omnis. Ut pariatur ad autem ducimus et. Voluptas rem voluptas sint modi dolorem amet.'
	 * @param  integer $maxNbChars Maximum number of characters the text should contain (minimum 5)
	 * @return string
	 */
	public static function text($maxNbChars = 200)
	{
		$text = array();
		if ($maxNbChars < 5) {
			throw new \InvalidArgumentException('text() can only generate text of at least 5 characters');
		} elseif ($maxNbChars < 25) {
			// join words
			while (empty($text)) {
				$size = 0;
				// determine how many words are needed to reach the $maxNbChars once;
				while ($size < $maxNbChars) {
					$word = ($size ? ' ' : '') . static::word();
					$text []= $word;
					$size += strlen($word);
				}
				array_pop($text);
			}
			$text[0][0] = static::toUpper($text[0][0]);
			$text[count($text) - 1] .= '.';
		} elseif ($maxNbChars < 100) {
			// join sentences
			while (empty($text)) {
				$size = 0;
				// determine how many sentences are needed to reach the $maxNbChars once;
				while ($size < $maxNbChars) {
					$sentence = ($size ? ' ' : '') . static::sentence();
					$text []= $sentence;
					$size += strlen($sentence);
				}
				array_pop($text);
			}
		} else {
			// join paragraphs
			while (empty($text)) {
				$size = 0;
				// determine how many paragraphs are needed to reach the $maxNbChars once;
				while ($size < $maxNbChars) {
					$paragraph = ($size ? "\n" : '') . static::paragraph();
					$text []= $paragraph;
					$size += strlen($paragraph);
				}
				array_pop($text);
			}
		}

		return join($text, '');
	}

	protected static function randomizeNbElements($nbElements)
	{
		return (int) ($nbElements * mt_rand(60, 140) / 100) + 1;
	}
}
