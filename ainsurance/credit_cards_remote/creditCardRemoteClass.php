<?php
/**
 * Created by PhpStorm.
 * User: m.ermogenous
 * Date: 27/04/2020
 * Time: 15:17
 */

/**
 * Class creditCardRemoteClass
 * The class that connects the ainsurance credit cards and the rcb credit cards systems together using api`s
 */

class creditCardRemoteClass {

    private $creditCardNumber = '';
    private $creditCardExpiryYear = 0;
    private $creditCardExpiryMonth = 0;
    private $creditCardCCV = 0;

    function __construct()
    {
    }

    public function createNewCard(){
        global $db;

    }

    /**
     * @param string $creditCardNumber
     * @return $this
     */
    public function setCreditCardNumber($creditCardNumber)
    {
        $this->creditCardNumber = $creditCardNumber;
        return $this;
    }

    /**
     * @param int $creditCardExpiryYear
     * @return $this
     */
    public function setCreditCardExpiryYear($creditCardExpiryYear)
    {
        $this->creditCardExpiryYear = $creditCardExpiryYear;
        return $this;
    }

    /**
     * @param int $creditCardExpiryMonth
     * @return $this
     */
    public function setCreditCardExpiryMonth($creditCardExpiryMonth)
    {
        $this->creditCardExpiryMonth = $creditCardExpiryMonth;
        return $this;
    }

    /**
     * @param int $creditCardCCV
     * @return $this
     */
    public function setCreditCardCCV($creditCardCCV)
    {
        $this->creditCardCCV = $creditCardCCV;
        return $this;
    }

}
