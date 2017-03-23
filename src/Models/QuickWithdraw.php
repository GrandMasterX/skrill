<?php

namespace grandmasterx\Skrill\Models;

use grandmasterx\Skrill\Components\AsArrayTrait;

/**
 * @package grandmasterx\Skrill\Models
 * @see https://www.skrill.com/fileadmin/content/pdf/Skrill_Quick_Checkout_Guide.pdf
 */
class QuickWithdraw extends Model
{
    use AsArrayTrait;

    const PREPARE = 'prepare';

    const TRANSFER = 'transfer';

    private $validActions = [
        self::PREPARE,
        self::TRANSFER
    ];

    /**
     * @var
     */
    protected $action;

    /**
     * @var
     */
    protected $email;

    /**
     * @var
     */
    protected $password;

    /**
     * @var
     */
    protected $amount;

    /**
     * @var
     */
    protected $currency;

    /**
     * @var
     */
    protected $bnf_email;

    /**
     * @var
     */
    protected $subject;

    /**
     * @var
     */
    protected $note;

    /**
     * @var
     */
    protected $frn_trn_id;

    /**
     * @var
     */
    protected $sid;

    /**
     * @return mixed
     */
    public function getAction() {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action) {
        if ($this->validateAction($action)) {
            $this->action = $action;
        } else {
            throwException(new \Exception('Wrong action'));
        }
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = md5($password);
    }

    /**
     * @return mixed
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getBnfEmail() {
        return $this->bnf_email;
    }

    /**
     * @param mixed $bnf_email
     */
    public function setBnfEmail($bnf_email) {
        $this->bnf_email = $bnf_email;
    }

    /**
     * @return mixed
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject) {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note) {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getFrnTrnId() {
        return $this->frn_trn_id;
    }

    /**
     * @param mixed $frn_trn_id
     */
    public function setFrnTrnId($frn_trn_id) {
        $this->frn_trn_id = $frn_trn_id;
    }

    /**
     * @return mixed
     */
    public function getSid() {
        return $this->sid;
    }

    /**
     * @param mixed $sid
     */
    public function setSid($sid) {
        $this->sid = $sid;
    }

    private function validateAction($action) {
        if (!in_array($action, $this->validActions)) {
            return false;
        } else {
            return true;
        }
    }
}