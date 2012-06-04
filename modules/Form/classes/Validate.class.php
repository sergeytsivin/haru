<?php
class Miao_Form_Validate
{

	/**
	 * Validator chain
	 *
	 * @var array
	 */
	protected $_validators = array();

	/**
	 * Array of validation failure messages
	 *
	 * @var array
	 */
	protected $_messages = array();

	/**
	 *
	 * @param unknown_type $validator
	 * @param unknown_type $breakChainOnFailure
	 */
	public function addValidator( $validator, $breakChainOnFailure = false )
	{
		if ( is_object( $validator ) )
		{
			$this->_addValidator( $validator, $breakChainOnFailure );
		}
		elseif ( is_string( $validator ) )
		{
			$className = __CLASS__ . '_' . ucfirst( $validator );
			$validator = new $className();
			$this->_addValidator( $validator, $breakChainOnFailure );
		}
	}

	public function getValidators()
	{
		return $this->_validators;
	}

	/**
	 *
	 * @param unknown_type $value
	 * @return boolean
	 */
	public function isValid( $value )
	{
		$this->_messages = array();
		$result = true;
		foreach ( $this->_validators as $element )
		{
			$validator = $element[ 'instance' ];
			if ( $validator->isValid( $value ) )
			{
				continue;
			}
			$result = false;
			$messages = $validator->getMessages();
			$this->_messages = array_merge( $this->_messages, $messages );
			if ( $element[ 'breakChainOnFailure' ] )
			{
				break;
			}
		}
		return $result;
	}

	public function getMessages()
	{
		return $this->_messages;
	}

	protected function _addValidator( Miao_Form_Validate_Base $validate, $breakChainOnFailure = false )
	{
		$item = array();
		$item[ 'instance' ] = $validate;
		$item[ 'breakChainOnFailure' ] = $breakChainOnFailure;
		$this->_validators[] = $item;
	}
}