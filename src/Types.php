<?php

namespace SendMate;

/**
 * @property string $session_id
 * @property string $url
 * @property string $status
 * @property string $reference
 * @property float $amount
 * @property string $currency
 * @property string $description
 * @property string $return_url
 * @property string $cancel_url
 */
class CheckoutSession {}

/**
 * @property string $reference
 * @property string $status
 * @property string $phone_number
 * @property float $amount
 * @property string $description
 */
class MpesaStkPushResponse {}

/**
 * @property string $status
 * @property string $reference
 * @property string $phone_number
 * @property float $amount
 * @property string $description
 * @property string $created_at
 */
class MpesaStatusResponse {}

/**
 * @property string $id
 * @property string $name
 * @property string $currency
 * @property float $balance
 * @property bool $is_default
 */
class Wallet {}

/**
 * @property string $id
 * @property string $type
 * @property float $amount
 * @property string $currency
 * @property string $status
 * @property string $reference
 * @property string $created_at
 */
class Transaction {} 