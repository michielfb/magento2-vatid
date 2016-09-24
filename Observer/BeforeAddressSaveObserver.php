<?php
namespace Michielfb\Vatid\Observer;

use Magento\Customer\Model\Vat;
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
     * @var Vat
     */
    protected $vat;

    /**
     * BeforeAddressSaveObserver constructor.
     * @param Vat $vat
     */
    public function __construct(Vat $vat)
    {
        $this->vat = $vat;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Customer\Model\Address $address */
        $address = $observer->getDataObject();

        if ($this->vat->isCountryInEU($address->getCountry())) {

            $vatId = strtoupper($address->getVatId());
            $countryId = strtoupper($address->getCountry());

            $vatId = $this->cleanup($vatId);
            $vatId = $this->removeCountryPrefix($vatId, $countryId);

            $address->setVatId($vatId);
        }
    }

    /**
     * Remove unwanted characters from the vat id.
     *
     * @param string $vatId
     * @return string
     */
    protected function cleanup($vatId)
    {
        return str_replace($this->getCharacters(), '', $vatId);
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

    /**
     * Get the characters that need to be removed.
     * @return array
     */
    public function getCharacters()
    {
        return $this->characters;
    }
}