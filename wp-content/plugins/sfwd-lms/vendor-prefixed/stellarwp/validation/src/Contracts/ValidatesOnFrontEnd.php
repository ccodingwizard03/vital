<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by learndash on 01-November-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace StellarWP\Learndash\StellarWP\Validation\Contracts;

interface ValidatesOnFrontEnd
{
    /**
     * Serializes the rule option for use on the front-end.
     *
     * @since 1.0.0
     *
     * @return int|float|string|bool|array|null
     */
    public function serializeOption();
}