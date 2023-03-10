<?php
/**
 * Sort Key Value Comparer Class
 *
 * @package   ParserPower
 * @author    Eyes <eyes@aeongarden.com>, Samuel Hilson <shilson@fandom.com>
 * @copyright Copyright � 2013 Eyes
 * @copyright 2019 Wikia Inc.
 * @license   GPL-2.0-or-later
 */

namespace ParserPower;

class ParserPowerSortKeyValueComparer {
	/**
	 * The function to use to compare sort keys.
	 *
	 * @var callable
	 */
	private $mSortKeyCompare;

	/**
	 * The function to use to compare values, if any.
	 *
	 * @var callable
	 */
	private $mValueCompare = null;

	/**
	 * Constructs a ParserPowerSortKeyComparer from the given options.
	 *
	 * @param int $sortKeyOptions The options for the key sort.
	 * @param bool $valueSort true to perform a value sort for values with the same key.
	 * @param int $valueOptions The options for the value sort.
	 */
	public function __construct( $sortKeyOptions, $valueSort, $valueOptions = 0 ) {
		$this->mSortKeyCompare = $this->getComparer( $sortKeyOptions );
		if ( $valueSort ) {
			$this->mValueCompare = $this->getComparer( $valueOptions );
		}
	}

	/**
	 * Compares a sort key-value pair where each pair is in an array with the sort key in element 0 and the value in
	 * element 1.
	 *
	 * @param array $pair1 A sort-key value pair to compare to $pair2
	 * @param array $pair2 A sort-key value pair to compare to $pair1
	 *
	 * @return int Number > 0 if str1 is less than str2; Number < 0 if str1 is greater than str2; 0 if they are equal.
	 */
	public function compare( $pair1, $pair2 ) {
		$result = call_user_func( $this->mSortKeyCompare, $pair1[0], $pair2[0] );

		if ( $result == 0 ) {
			if ( $this->mValueCompare ) {
				return call_user_func( $this->mValueCompare, $pair1[1], $pair2[1] );
			} else {
				return 0;
			}
		} else {
			return $result;
		}
	}

	/**
	 * Get Comparer class with method or core function.
	 *
	 * For future developers to not waste time. Somebody invented that, so lets try to explain...
	 * Bit matrix used here (examples by power of 2, description little endian):
	 * +---+---+---+
	 * | 4 | 2 | 1 | < - bit values
	 * +===+===+===+
	 * | 1 | 0 | 1 | (INT 5) Numeric sorting DESC
	 * | 1 | 0 | 0 | (INT 4) Numeric sorting ASC
	 * | 0 | 1 | 1 | (INT 3) String sorting (CS) case-sensitive DESC
	 * | 0 | 1 | 0 | (INT 2) String sorting (CS) case-sensitive ASC
	 * | 0 | 0 | 1 | (INT 1) String sorting (CI) case-insensitive DESC
	 * | 0 | 0 | 0 | (INT 0) String sorting (CI) case-insensitive ASC
	 * +---+---+---+
	 *
	 * @param int $options
	 *
	 * @return ?callable If something broke up the call-stack this could potentially return null
	 */
	private function getComparer( $options ) {
		if ( $options & ParserPowerLists::SORT_NUMERIC ) {
			if ( $options & ParserPowerLists::SORT_DESC ) {
				// 101 NUM DESC
				return 'ParserPower\\ParserPowerCompare::numericrstrcmp';
			} else {
				// 100 NUM ASC
				return 'ParserPower\\ParserPowerCompare::numericstrcmp';
			}
		} else {
			if ( $options & ParserPowerLists::SORT_CS ) {
				if ( $options & ParserPowerLists::SORT_DESC ) {
					// 011 STR CS DESC
					return 'ParserPower\\ParserPowerCompare::rstrcmp';
				} else {
					// 010 STR CS ASC
					return 'strcmp';
				}
			} else {
				if ( $options & ParserPowerLists::SORT_DESC ) {
					// 001 STR CI DESC
					return 'ParserPower\\ParserPowerCompare::rstrcasecmp';
				} else {
					// 000 STR CI ASC
					return 'strcasecmp';
				}
			}
		}
	}
}
