<?php

/**
 * Class StackExchange_RequiredTelephone_Model_Observer
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 */
class StackExchange_RequiredTelephone_Model_Observer
{
    /**
     * Validate address ignoring phone-related errors
     *
     * Internally uses reflexion. Maybe not the most
     * efficient or clean implementation, but allows
     * this functionality to be implemented without
     * the need to rewrite 3 core classes.
     *
     * Listens to:
     * - customer_address_validation_after
     *
     * @param Varien_Event_Observer $observer Event observer
     * @throws ReflectionException
     */
    public function validateAddress(Varien_Event_Observer $observer)
    {
        /* @var Mage_Customer_Model_Address_Abstract $address */
        $address = $observer->getAddress();
        if (!$address) {
            return;
        }

        $prop = new ReflectionProperty('Mage_Customer_Model_Address_Abstract', '_errors');
        if (!$prop) {
            return;
        }
        $prop->setAccessible(true);
        $errors = $prop->getValue($address);
        $prop->setValue($address, []);

        $errorMessage = $this->getErrorMessage();
        foreach ($errors as $error) {
            if ($error !== $errorMessage) {
                $address->addError($error);
            }
        }
    }

    /**
     * Get standard error message
     *
     * @return string
     */
    protected function getErrorMessage()
    {
        return Mage::helper('customer')->__('Please enter the telephone number.');
    }
}
