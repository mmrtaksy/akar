<?php
namespace App\Services;

use Iyzipay\Options;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Iyzipay\Request\CreatePaymentRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\Payment;
use App\Helpers\Helper;
use Session;

class IyzicoService
{
    protected $options;

    public function __construct()
    {
        $this->options = new Options();
        $this->options->setApiKey(config('iyzico.api_key'));
        $this->options->setSecretKey(config('iyzico.secret_key'));
        $this->options->setBaseUrl(config('iyzico.base_url'));
    }


    public function initializeCheckoutForm($paymentData)
    {

        $conversation_id = rand(100000,999999);
		$basket_id = rand(100000,999999);

        $auth = Auth::user();
        $encryptedUserId = Crypt::encrypt($auth->id);


        
        $request = new CreateCheckoutFormInitializeRequest();
        $request->setLocale("tr");
        $request->setConversationId($conversation_id);
        $request->setPrice($paymentData['price']);
        $request->setPaidPrice($paymentData['price']);
        $request->setCurrency("TRY");
		$request->setBasketId($basket_id);
        $request->setPaymentGroup("PRODUCT");

         $basketTotalPrice = array_reduce($paymentData['items'], function ($carry, $item) {
            return $carry + $item['price'];
        }, 0);

        $request->setPrice($basketTotalPrice);
        $request->setPaidPrice($basketTotalPrice);

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName($paymentData['name']);
        $buyer->setSurname($paymentData['surname']);
        $buyer->setGsmNumber($paymentData['phone']);
        $buyer->setEmail($paymentData['email']);
        $buyer->setIdentityNumber($paymentData['billing']['tc_no']);
        $buyer->setRegistrationAddress($paymentData['address']);
        $buyer->setIp($paymentData['ip']);
        $buyer->setCity($paymentData['city']);
        $buyer->setCountry($paymentData['country']);
        $buyer->setZipCode("34732");
        $request->setBuyer($buyer);

        $address = new \Iyzipay\Model\Address();
        $address->setContactName($paymentData['billing']['name']);
        $address->setCity($paymentData['billing']['city']);
        $address->setCountry($paymentData['billing']['country']);
        $address->setAddress($paymentData['billing']['address']);
        $address->setZipCode("34732");
        $request->setShippingAddress($address);
        $request->setBillingAddress($address);

        


        $basketItems = [];
        foreach ($paymentData['items'] as $item) {
            $basketItem = new \Iyzipay\Model\BasketItem();
            $basketItem->setId($item['id']);
            $basketItem->setName($item['name']);
            $basketItem->setCategory1("ads package");
            $basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
            $basketItem->setPrice($item['price']);
            $basketItems[] = $basketItem;
            $encryptedPackageId = Crypt::encrypt($item['package_id']);
        }
        $request->setBasketItems($basketItems);

        
        $request->setCallbackUrl(url(app()->getLocale() . '/account/package/take/checkout?key=' . $encryptedUserId . '&pid=' . $encryptedPackageId)); 

        $checkoutFormInitialize = CheckoutFormInitialize::create($request, $this->options);


        return $checkoutFormInitialize;
    }



    public function callback($token){
        $retrieveCheckoutFormRequest = new RetrieveCheckoutFormRequest();
        $retrieveCheckoutFormRequest->setLocale("tr");
        $retrieveCheckoutFormRequest->setToken($token);
    
        $data = CheckoutForm::retrieve($retrieveCheckoutFormRequest, $this->options);
     
   
        return $data;
        
    }

}
