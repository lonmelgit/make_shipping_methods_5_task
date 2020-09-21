<?php

namespace Make\Ship\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Make\Ship\Model\ResourceModel\Ways\CollectionFactory;
use Psr\Log\LoggerInterface;
use Magento\Checkout\Model\CartFactory;

class FixShipping extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{

    protected $_code = 'MegaShipping';
    protected $shipwaysFactory;
    protected $cartFactory;


    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        CollectionFactory $shipwaysFactory,
        CartFactory $cartFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->shipwaysFactory = $shipwaysFactory;
        $this->cartFactory = $cartFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }


    public function getAllowedMethods()
    {
        return ['MegaShipping' => $this->getConfigData('name')];
    }

    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $cart = $this->cartFactory->create(); // делаем объект корзины
        $subTotal = $cart->getQuote()->getSubtotal(); // вытягиваем из корзины заказ и берем стоимость заказа
        $items = $cart->getQuote()->getAllItems();// вытягиваем из заказа все товары

        $weight = 0;
        foreach ($items as $item) {
            $weight += ($item->getWeight() * $item->getQty());  // считаем вес заказа, суммируя вес каждого товара, умноженного на его количество
        }

        $result = $this->_rateResultFactory->create();
        $collection = $this->shipwaysFactory->create();  // получаем объект, в котором содержатся все методы доставки

        foreach ($collection as $coll) {

            $min_subtotal = $coll->getMinSubtotal();  // получаем по каждому методу его параметры, определенные в соответствующих колонках в ГРИДЕ
            $max_subtotal = $coll->getMaxSubtotal();
            $min_weight = $coll->getMinWeight();
            $max_weight = $coll->getMaxWeight();
            $status = $coll->getStatus();

            if ($min_subtotal <= $subTotal && $subTotal <= $max_subtotal && // определяем условие, при котором тот, или иной метод может создаваться
                $min_weight <= $weight && $weight <= $max_weight &&
                $status == 1
            ) {

                $percent = $coll->getPercent(); //

                $method = $this->_rateMethodFactory->create(); // создаем метод
                $method->setCarrier($this->_code);  // опреедлен в сonfig.xml
                $method->setCarrierTitle('MegaShipping');

                $method->setMethod($coll->getId()); // получаем id метода
                $method->setMethodTitle($coll->getName()); // получаем имя метода

                $amount = $coll->getPrice(); // получаем цену метода
                $method->setPrice($amount + $amount * $percent / 100); // устанавливаем новую цену
                $method->setCost($amount + $amount * $percent / 100);

                $result->append($method);
            }

        }
        return $result;
    }
}
