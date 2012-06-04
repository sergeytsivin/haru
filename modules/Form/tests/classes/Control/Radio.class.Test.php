<?php
class Miao_Form_Control_Radio_Test extends PHPUnit_Framework_TestCase
{

	/**
	 * @dataProvider providerTestMain
	 */
	public function testMain( $name, $actual, $value = '', $attributes = array(), $exceptionName = '' )
	{
		if ( !empty( $exceptionName ) )
		{
			$this->setExpectedException( $exceptionName );
		}

		$control = new Miao_Form_Control_Radio( $name );
		$control->setValue( $value );
		$control->setAttributes( $attributes );

		$expected = $control->render();

		$this->assertEquals( $expected, $actual );
	}

	public function providerTestMain()
	{
		$data = array();

		$actual = '<input id="sex" name="sex" value="male" type="radio" />';
		$data[] = array( 'sex', $actual, 'male' );

		return $data;
	}
}