<?php

require_once 'SwatDB/SwatDBDataObject.php';
require_once 'SwatDB/SwatDBClassMap.php';
require_once 'Inquisition/dataobjects/InquisitionInquisition.php';
require_once 'Inquisition/dataobjects/InquisitionResponseValueWrapper.php';

/**
 * A inquisition response
 *
 * @package   Inquisition
 * @copyright 2011 silverorange
 */
class InquisitionResponse extends SwatDBDataObject
{
	// {{{ public properties

	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var SwatDate
	 */
	public $createdate;

	/**
	 * @var SwatDate
	 */
	public $complete_date;

	// }}}
	// {{{ protected function init()

	protected function init()
	{
		$this->table = 'InquisitionResponse';
		$this->id_field = 'integer:id';

		$this->registerDateProperty('createdate');
		$this->registerDateProperty('complete_date');

		$this->registerInternalProperty('inquisition',
			SwatDBClassMap::get('InquisitionInquisition'));
	}

	// }}}
	// {{{ protected function getSerializableSubDataObjects()

	protected function getSerializableSubDataObjects()
	{
		return array_merge(parent::getSerializableSubDataObjects(), array(
			'values',
		));
	}

	// }}}

	// loader methods
	// {{{ protected function loadValues()

	protected function loadValues()
	{
		$sql = sprintf('select * from InquisitionResponseValue
			where response = %s',
			$this->db->quote($this->id, 'integer'));

		$wrapper = SwatDBClassMap::get('InquisitionResponseValueWrapper');

		return SwatDB::query($this->db, $sql, $wrapper);
	}

	// }}}
}

?>
