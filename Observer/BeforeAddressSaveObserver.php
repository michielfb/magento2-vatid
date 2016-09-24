<?php
namespace Michielfb\Vatid\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class BeforeAddressSaveObserver implements ObserverInterface
{
    /**
     * @var array Characters to remove from vat ids.
     */
    protected $characters = [
        ',', '.', '-', ' ',
    ];

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Customer\Model\Address $address */
        $address = $observer->getDataObject();

        $vatId      = strtoupper($address->getVatId());
        $countryId  = strtoupper($address->getCountryId());

        $vatId = $this->cleanup($vatId);


        $vatId = $this->removeCountryPrefix($vatId, $countryId);

        $address->setVatId($vatId);
    }

    /**
     * Remove unwanted characters from the vat id.
     *
     * @param string $vatId
     * @return string
     */
    protected function cleanup($vatId)
    {
        return str_replace($this->characters, '', $vatId);
    }

    /**
     * Remove the country prefix if present.
     *
     * @param $vatId
     * @param $countryId
     * @return string
     */
    protected function removeCountryPrefix($vatId, $countryId)
    {
        if (substr($vatId, 0, 2) == $countryId) {
            $vatId = substr($vatId, 2);
        }

        return $vatId;
    }
}