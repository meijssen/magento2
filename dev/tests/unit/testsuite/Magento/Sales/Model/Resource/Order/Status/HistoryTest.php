<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Sales\Model\Resource\Order\Status;

/**
 * Class HistoryTest
 * @package Magento\Sales\Model\Resource\Order\Status
 */
class HistoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Sales\Model\Resource\Order\Status\History
     */
    protected $historyResource;

    /**
     * @var \Magento\Framework\App\Resource|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $appResourceMock;

    /**
     * @var \Magento\Sales\Model\Order\Status\History|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $historyMock;

    /**
     * @var \Magento\Framework\DB\Adapter\Pdo\Mysql|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $adapterMock;

    /**
     * @var \Magento\Sales\Model\Order\Status\History\Validator|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $validatorMock;

    public function setUp()
    {
        $this->appResourceMock = $this->getMock(
            'Magento\Framework\App\Resource',
            [],
            [],
            '',
            false
        );
        $this->adapterMock = $this->getMock(
            'Magento\Framework\DB\Adapter\Pdo\Mysql',
            [],
            [],
            '',
            false
        );
        $this->validatorMock = $this->getMock(
            'Magento\Sales\Model\Order\Status\History\Validator',
            [],
            [],
            '',
            false
        );
        $this->appResourceMock->expects($this->any())
            ->method('getConnection')
            ->will($this->returnValue($this->adapterMock));
        $objectManager = new \Magento\TestFramework\Helper\ObjectManager($this);
        $this->adapterMock->expects($this->any())
            ->method('describeTable')
            ->will($this->returnValue([]));
        $this->adapterMock->expects($this->any())
            ->method('insert');
        $this->adapterMock->expects($this->any())
            ->method('lastInsertId');

        $relationProcessorMock = $this->getMock(
            '\Magento\Framework\Model\Resource\Db\ObjectRelationProcessor',
            [],
            [],
            '',
            false
        );

        $contextMock = $this->getMock('\Magento\Framework\Model\Resource\Db\Context', [], [], '', false);
        $contextMock->expects($this->once())->method('getResources')->willReturn($this->appResourceMock);
        $contextMock->expects($this->once())->method('getObjectRelationProcessor')->willReturn($relationProcessorMock);

        $this->historyResource = $objectManager->getObject(
            'Magento\Sales\Model\Resource\Order\Status\History',
            [
                'context' => $contextMock,
                'validator' => $this->validatorMock
            ]
        );
    }

    /**
     * test _beforeSaveMethod via save()
     */
    public function testSave()
    {
        $historyMock = $this->getMock(
            'Magento\Sales\Model\Order\Status\History',
            [],
            [],
            '',
            false
        );
        $historyMock->expects($this->any())->method('hasDataChanges')->will($this->returnValue(true));
        $historyMock->expects($this->any())->method('isSaveAllowed')->will($this->returnValue(true));
        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($historyMock)
            ->will($this->returnValue([]));
        $historyMock->expects($this->any())->method('getData')->willReturn([]);
        $this->historyResource->save($historyMock);
    }

    /**
     * test _beforeSaveMethod via save()
     * @expectedException \Magento\Framework\Exception\LocalizedException
     * @expectedExceptionMessage Cannot save comment:
     */
    public function testValidate()
    {
        $historyMock = $this->getMock(
            'Magento\Sales\Model\Order\Status\History',
            [],
            [],
            '',
            false
        );
        $historyMock->expects($this->any())->method('hasDataChanges')->will($this->returnValue(true));
        $historyMock->expects($this->any())->method('isSaveAllowed')->will($this->returnValue(true));
        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($historyMock)
            ->will($this->returnValue(['Some warnings']));
        $this->assertEquals($this->historyResource, $this->historyResource->save($historyMock));
    }
}
