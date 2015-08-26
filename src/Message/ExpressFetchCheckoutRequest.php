<?php

namespace Omnipay\PayPal\Message;

/**
 * PayPal Express Fetch Checkout Details Request
 */
class ExpressFetchCheckoutRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate();

        $data = $this->getBaseData();
        $data['METHOD'] = 'GetExpressCheckoutDetails';

        // token can either be specified directly, or inferred from the GET parameters
        if ($this->getToken()) {
            $data['TOKEN'] = $this->getToken();
        } else {
            $data['TOKEN'] = $this->httpRequest->query->get('token');
        }
        
        $url = $this->getEndpoint() . "?USER={$data['USER']}&PWD={$data['PWD']}&SIGNATURE={$data['SIGNATURE']}&METHOD=$data[METHOD]&VERSION={$data['VERSION']}&TOKEN={$data['TOKEN']}";
        parse_str(file_get_contents($url), $output);
        
        $data = array_merge($data, $output);

        return $data;
    }
}
