<?php
/**
 * @license GPL-2.0
 *
 * Modified by learndash on 01-November-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace StellarWP\Learndash\StellarWP\DB\QueryBuilder\Clauses;

/**
 * @since 1.0.0
 */
class Select {
	/**
	 * @var string
	 */
	public $column;

	/**
	 * @var string
	 */
	public $alias;

	/**
	 * @param  string  $column
	 * @param  string|null  $alias
	 */
	public function __construct( $column, $alias = null ) {
		$this->column = trim( $column );
		$this->alias  = trim( $alias );
	}
}
