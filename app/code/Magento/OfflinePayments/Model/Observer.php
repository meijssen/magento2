<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright   Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * OfflinePayments Observer
 */
namespace Magento\OfflinePayments\Model;

class Observer
{
    /**
     * Sets current instructions for bank transfer account
     *
     * @param \Magento\Event\Observer $observer
     * @return void
     */
    public function beforeOrderPaymentSave(\Magento\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order\Payment $payment */
        $payment = $observer->getEvent()->getPayment();
        $banktransfer = \Magento\OfflinePayments\Model\Banktransfer::PAYMENT_METHOD_BANKTRANSFER_CODE;
        if ($payment->getMethod() === $banktransfer) {
            $payment->setAdditionalInformation('instructions', $payment->getMethodInstance()->getInstructions());
        }
    }
}