<?php
class arsenalpayPayment extends payment
{
    protected $callbackResponse = array(
        'ID', /* Идентификатор ТСП/ merchant identifier */
        'FUNCTION', /* Тип запроса/ type of request to which the response is received */
        'RRN' , /* Идентификатор транзакции/ transaction identifier */
        'PAYER', /* Идентификатор плательщика/ payer(customer) identifier */
        'AMOUNT', /* Сумма платежа/ payment amount */
        'ACCOUNT' , /* Номер получателя платежа (номер заказа, номер ЛС) на стороне ТСП/ order number */
        'STATUS', /* Статус платежа - check - запрос на проверку номера получателя : payment - запрос на передачу статуса платежа
          /* Payment status. When 'check' - response for the order number checking, when 'payment' - response for status change. */
        'DATETIME', /* Дата и время в формате ISO-8601 (YYYY-MM-DDThh:mm:ss±hh:mm), УРЛ-кодированное */
        /* Date and time in ISO-8601 format, urlencoded. */
        'SIGN', /* Подпись запроса/ response sign.
              /* = md5(md5(ID).md(FUNCTION).md5(RRN).md5(PAYER).md5(AMOUNT).md5(ACCOUNT).md(STATUS).md5(PASSWORD)) */
    );

    public function validate() {
        return true;
    }

    public static function getOrderId(){
        return (int) getRequest('ACCOUNT');
    }


    public function process($template = null) {
        $this->order->order();

        $widgetSecretKey = $this->object->widget_key;
        $widgetId = $this->object->widget_id;
        $callbackSecretKey = $this->object->callback_key;

        $destination = $this->order->getId();
        $amount = (float) $this->order->getActualPrice();

        if (!strlen($widgetSecretKey) || !is_numeric($widgetId) || !strlen($callbackSecretKey)) {
            throw new publicException(getLabel('error-payment-wrong-settings'));
        }
        
        $userId = $this->order->getCustomerId(); 
        $nonce = md5(microtime(true) . mt_rand(100000, 999999));
        $signData = "$userId;$destination;$amount;$widgetId;$nonce";
        $widgetSign = hash_hmac('sha256', $signData, $widgetSecretKey);
        
        $params = array();

        $params['widget'] = $widgetId;
        $params['amount'] = $amount;
        $params['userId'] = $userId;
        $params['nonce'] = $nonce;
        $params['widgetSign'] = $widgetSign;
        $params['destination'] = $destination;

        $this->order->setPaymentStatus('initialized');

        list($form_block) =
            def_module::loadTemplates('emarket/payment/arsenalpay/' . $template, 'form_block');

        return def_module::parseTemplate($form_block, $params);
    }


    public function poll() {
        ob_start();
        $requestStatus = getRequest('STATUS');

        $remoteAddress = $_SERVER["REMOTE_ADDR"];
        $logString = date("Y-m-d H:i:s") . " " . $remoteAddress . " ";
        $this->postLog($logString);
        $isValid = $this->validateCallback();
        $answer = 'ERR';
        if ($isValid) {
            if ($requestStatus == 'check') {
                $answer = 'YES';
            }
            else if ($requestStatus == 'payment') {
                $answer = 'OK';
                $this->order->setPaymentStatus("accepted"); 
            }
        } else {
            if ($requestStatus == 'check') {
                $answer = 'NO';
            } else {
                $answer = 'ERR';
            }
        }
        $this->postLog("ANSWER : ".$answer);
        ob_end_clean();
        echo $answer;
        die();
    }

    private function validateCallback() {
        $error = false;
        $requestArray = array();
        $this->postLog("Arsenalpay params:");
        foreach ($this->callbackResponse as $key) {
            $requestArray[$key] = getRequest($key);
            if (is_null($requestArray[$key])) {
                $error = $this->addError("Missing ".$key." in response");
            } else {
                $this->postLog("{$key}={$requestArray[$key]}&");
            }
        }

        if ($error) {
            return !$error;
        }

        if (!$this->order->getId() ) {
            $error = $this->addError("Cart is not founded in db. ACCOUNT=".$requestArray['ACCOUNT']);
        } else {
            $amount = (float) $this->order->getActualPrice();
            $lessAmount = false;
            if (!$this->check_sign($requestArray)) {
                $error = $this->addError("Invalid signature");
            } else if ($requestArray['MERCH_TYPE'] == 0 &&  $amount ==  $requestArray['AMOUNT']) {
                $lessAmount = false;
            } else if($requestArray['MERCH_TYPE'] == 1 && $amount >= $requestArray['AMOUNT'] && 
                $amount ==  $requestArray['AMOUNT_FULL']) {
                $lessAmount = true;
            } else {
                $error = $this->addError("Wrong callback sum");
            }
            
            if ($lessAmount) {
                $this->postLog("Callback response with less amount {$requestArray['AMOUNT']}");
            }
        }
        return !$error;
    }
 
    private function check_sign($requestArray) {
        $callbackSecretKey = $this->object->callback_key;
        $validSign = ( $requestArray['SIGN'] === md5(md5($requestArray['ID']). 
                md5($requestArray['FUNCTION']).md5($requestArray['RRN']). 
                md5($requestArray['PAYER']).md5($requestArray['AMOUNT']).md5($requestArray['ACCOUNT']). 
                md5($requestArray['STATUS']).md5($callbackSecretKey) ) )? true : false;
        return $validSign;
    }

    private function addError($str) {
        $this->postLog('ERR: '.$str);
        return $str;
    }

    private function postLog($str) {
        $fp = fopen($_SERVER['DOCUMENT_ROOT']. "/errors/logs/arsenalpay_callback.log", "a+");
        fwrite($fp, $str . "\r\n");
        fclose($fp);

        return $str;
    }
};
?>