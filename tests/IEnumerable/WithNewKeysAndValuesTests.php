<?php

/**********************************************************************************************************************
 * phpLINQ (https://github.com/mkloubert/phpLINQ)                                                                     *
 *                                                                                                                    *
 * Copyright (c) 2015, Marcel Joachim Kloubert <marcel.kloubert@gmx.net>                                              *
 * All rights reserved.                                                                                               *
 *                                                                                                                    *
 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the   *
 * following conditions are met:                                                                                      *
 *                                                                                                                    *
 * 1. Redistributions of source code must retain the above copyright notice, this list of conditions and the          *
 *    following disclaimer.                                                                                           *
 *                                                                                                                    *
 * 2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the       *
 *    following disclaimer in the documentation and/or other materials provided with the distribution.                *
 *                                                                                                                    *
 * 3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote    *
 *    products derived from this software without specific prior written permission.                                  *
 *                                                                                                                    *
 *                                                                                                                    *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, *
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE  *
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, *
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR    *
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,  *
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE   *
 * USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.                                           *
 *                                                                                                                    *
 **********************************************************************************************************************/

use \System\Collections\IEnumerable;


function withNewKeysAndValuesKeySelectorFunc($x) : string {
    return chr(ord('A') + $x);
}

function withNewKeysAndValuesValueSelectorFunc($x) : float {
    return (float)$x;
}

class KeySelectorClass {
    public function __invoke($x) {
        return withNewKeysAndValuesKeySelectorFunc($x);
    }
}

class ValueSelectorClass {
    public function __invoke($x) {
        return withNewKeysAndValuesValueSelectorFunc($x);
    }
}

/**
 * @see \System\Collections\IEnumerable::withNewKeysAndValues()
 *
 * @author Marcel Joachim Kloubert <marcel.kloubert@gmx.net>
 */
class WithNewKeysAndValuesTests extends TestCaseBase {
    /**
     * Creates the key selectors for the tests.
     *
     * @return array The key selectors.
     */
    protected function createKeySelectors() : array {
        return [
            function($x) {
                return withNewKeysAndValuesKeySelectorFunc($x);
            },
            'withNewKeysAndValuesKeySelectorFunc',
            '\withNewKeysAndValuesKeySelectorFunc',
            new KeySelectorClass(),
            [$this, 'keySelectorMethod1'],
            [static::class, 'keySelectorMethod2'],
            '$x => withNewKeysAndValuesKeySelectorFunc($x)',
            '$x => \withNewKeysAndValuesKeySelectorFunc($x)',
            '($x) => withNewKeysAndValuesKeySelectorFunc($x)',
            '($x) => \withNewKeysAndValuesKeySelectorFunc($x)',
            '$x => return withNewKeysAndValuesKeySelectorFunc($x);',
            '$x => return \withNewKeysAndValuesKeySelectorFunc($x);',
            '($x) => return withNewKeysAndValuesKeySelectorFunc($x);',
            '($x) => return \withNewKeysAndValuesKeySelectorFunc($x);',
            '$x => { return withNewKeysAndValuesKeySelectorFunc($x); }',
            '$x => { return \withNewKeysAndValuesKeySelectorFunc($x); }',
            '($x) => { return withNewKeysAndValuesKeySelectorFunc($x); }',
            '($x) => { return \withNewKeysAndValuesKeySelectorFunc($x); }',
            '$x => {
return withNewKeysAndValuesKeySelectorFunc($x);
}',
            '$x => {
return \withNewKeysAndValuesKeySelectorFunc($x);
}',
            '($x) => {
return withNewKeysAndValuesKeySelectorFunc($x);
}',
            '($x) => {
return \withNewKeysAndValuesKeySelectorFunc($x);
}',
        ];
    }

    /**
     * Creates the value selectors for the tests.
     *
     * @return array The value selectors.
     */
    protected function createValueSelectors() : array {
        return [
            function($x) {
                return withNewKeysAndValuesValueSelectorFunc($x);
            },
            'withNewKeysAndValuesValueSelectorFunc',
            '\withNewKeysAndValuesValueSelectorFunc',
            new ValueSelectorClass(),
            [$this, 'valueSelectorMethod1'],
            [static::class, 'valueSelectorMethod2'],
            '$x => withNewKeysAndValuesValueSelectorFunc($x)',
            '$x => \withNewKeysAndValuesValueSelectorFunc($x)',
            '($x) => withNewKeysAndValuesValueSelectorFunc($x)',
            '($x) => \withNewKeysAndValuesValueSelectorFunc($x)',
            '$x => return withNewKeysAndValuesValueSelectorFunc($x);',
            '$x => return \withNewKeysAndValuesValueSelectorFunc($x);',
            '($x) => return withNewKeysAndValuesValueSelectorFunc($x);',
            '($x) => return \withNewKeysAndValuesValueSelectorFunc($x);',
            '$x => { return withNewKeysAndValuesValueSelectorFunc($x); }',
            '$x => { return \withNewKeysAndValuesValueSelectorFunc($x); }',
            '($x) => { return withNewKeysAndValuesValueSelectorFunc($x); }',
            '($x) => { return \withNewKeysAndValuesValueSelectorFunc($x); }',
            '$x => {
return withNewKeysAndValuesValueSelectorFunc($x);
}',
            '$x => {
return \withNewKeysAndValuesValueSelectorFunc($x);
}',
            '($x) => {
return withNewKeysAndValuesValueSelectorFunc($x);
}',
            '($x) => {
return \withNewKeysAndValuesValueSelectorFunc($x);
}',
        ];
    }

    public function keySelectorMethod1($x) {
        return withNewKeysAndValuesKeySelectorFunc($x);
    }

    public static function keySelectorMethod2($x) {
        return withNewKeysAndValuesKeySelectorFunc($x);
    }

    public function test1() {
        foreach ($this->createKeySelectors() as $keySelector) {
            foreach ($this->createValueSelectors() as $valueSelector) {
                foreach (static::sequenceListFromArray([1, '2', 3.4]) as $seq) {
                    /* @var IEnumerable $seq */

                    $items = static::sequenceToArray($seq->withNewKeysAndValues($keySelector, $valueSelector));

                    $this->assertEquals(3, count($items));

                    $this->assertTrue(isset($items['A']));
                    $this->assertFalse(isset($items[0]));
                    $this->assertSame(1.0, $items['A']);

                    $this->assertTrue(isset($items['B']));
                    $this->assertFalse(isset($items[1]));
                    $this->assertSame(2.0, $items['B']);

                    $this->assertTrue(isset($items['C']));
                    $this->assertFalse(isset($items[2]));
                    $this->assertSame(3.4, $items['C']);
                }
            }
        }
    }

    public function valueSelectorMethod1($x) {
        return withNewKeysAndValuesValueSelectorFunc($x);
    }

    public static function valueSelectorMethod2($x) {
        return withNewKeysAndValuesValueSelectorFunc($x);
    }
}
