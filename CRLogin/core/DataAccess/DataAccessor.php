<?php

/**
 *
 * DataAccessor: interface; Defines the CRUD operation methods for the Data Access classes
 * 
 * 
 * @package CRLogin
 * @subpackage core/Data Access
 * @author Nikos Koutelidis nikoutel@gmail.com
 * @copyright 2013 Nikos Koutelidis 
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link https://github.com/nikoutel/CRLogin 
 * 
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 * 
 */

namespace CRLogin\core\DataAccess;

interface DataAccessor {

    /**
     * Creates entries in the data store
     * 
     * @param array $values 
     *  If an associative array is given the keys will be the fields, 
     * and the array values the field values.
     * If an numeric array is given, the method will try 
     * to associate the array values to the field values
     * in order of the field when the dataset was created
     * 
     * @param string $dataSet The dataset to store the values
     */
    public function create(array $values, $dataSet);

    /**
     * Reads entries from the data store
     * 
     * @param array $fields An array with the fields to read
     * 
     * @param string $dataset The dataset to read from
     * 
     * @param array $conditions
     *  An array representing the logical conditions. Each level is represented by an array with the form:
     * array('LOGICAL_OPARATOR' , 'FIELD' , 'OPARATOR' , 'VALUE')
     * On a simple condition like : (id = '10') 
     * the array would be : array('' , 'id' , '=' , '10').
     * A more complex example:  (Country = 'Germany' AND (city = 'Berlin' OR City = 'Muenchen'))
     * array(
     *      array('', 'Country', '=', 'Germany'),
     *      array('AND',
     *           array(
     *                array('', 'city', '=', 'Berlin'),
     *                array('OR', 'city', '=', 'Muenchen')
     *           )
     *      )
     * )
     */
    public function read(array $fields, $dataset, array $conditions);

    /**
     * Updates entries in the data store
     * 
     * @param array $values
     *  If an associative array is given the keys will be the fields, 
     * and the array values the field values.
     * If an numeric array is given, the method will try 
     * to associate the array values to the field values
     * in order of the field when the table was created
     * 
     * @param string $dataSet The dataset to be updated
     * 
     * @param array $conditions
     *  An array representing the logical conditions. Each level is represented by an array with the form:
     * array('LOGICAL_OPARATOR' , 'FIELD' , 'OPARATOR' , 'VALUE')
     * On a simple condition like : (id = '10') 
     * the array would be : array('' , 'id' , '=' , '10').
     * A more complex example:  (Country = 'Germany' AND (city = 'Berlin' OR City = 'Muenchen'))
     * array(
     *      array('', 'Country', '=', 'Germany'),
     *      array('AND',
     *           array(
     *                array('', 'city', '=', 'Berlin'),
     *                array('OR', 'city', '=', 'Muenchen')
     *           )
     *      )
     * )
     */
    public function update(array $values, $dataSet, array $conditions);

    /**
     * Deletes entries from the data store
     * 
     * @param string $dataSet The dataset to be deleted
     * 
     * @param array $conditions
     *  An array representing the logical conditions. Each level is represented by an array with the form:
     * array('LOGICAL_OPARATOR' , 'FIELD' , 'OPARATOR' , 'VALUE')
     * On a simple condition like : (id = '10') 
     * the array would be : array('' , 'id' , '=' , '10').
     * A more complex example:  (Country = 'Germany' AND (city = 'Berlin' OR City = 'Muenchen'))
     * array(
     *      array('', 'Country', '=', 'Germany'),
     *      array('AND',
     *           array(
     *                array('', 'city', '=', 'Berlin'),
     *                array('OR', 'city', '=', 'Muenchen')
     *           )
     *      )
     * )
     */
    public function delete($dataSet, array $conditions);
}

?>
