<?php
/**
 * Created by Humcommerce.
 * Date: 18/10/18
 */

namespace Magecrafts\AdminSearch\Test\Unit;

use Magecrafts\AdminSearch\Model\QueryParser;
use PHPUnit\Framework\TestCase;

class QueryParserTest extends TestCase
{
    /**
     * @var QueryParser
     */
    protected $sut;

    protected function setUp(){
          $this->sut = new  QueryParser();
    }

    public function testWhenQueryContainsOrderIncreamentId()
    {
        $term = 'In Order #1552';
        $result = $this->sut->getQuery($term);

        $expected = ['type'=>'order','increament_id'=>'1552'];

        $this->assertEquals($expected,$result);

    }

    public function testWhenQueryContainsOrderEmail(){
        $term = 'Order john.doe@exmaple.com';
        $result = $this->sut->getQuery($term);

        $expected = ['type'=>'order','email'=>'john.doe@exmaple.com'];
        $this->assertEquals($expected,$result);
    }

    public function testWhenQueryContainsPurchaseDate(){
        //@TODO date can come in many formats
        $term = 'Order 2 april 2018';
        $result = $this->sut->getQuery($term);

        $expected = ['type'=>'order','purchase_date'=>'02/05/2018'];
        $this->assertEquals($expected,$result);
    }
}
