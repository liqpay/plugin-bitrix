<?php
/**
 * Liqpay Payment Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category        Liqpay
 * @package         liqpay.liqpay
 * @version         3.0
 * @author          Liqpay
 * @copyright       Copyright (c) 2014 Liqpay
 * @license         http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 *
 * EXTENSION INFORMATION
 *
 * 1C-Bitrix        14.0
 * LIQPAY API       https://www.liqpay.ua/documentation/ru
 *
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); }

$success =
    isset($_POST['data']) &&
    isset($_POST['signature']);

if (!$success) { die(); }

$data                = $_POST['data'];
$parsed_data         = json_decode(base64_decode($data), true);
$received_signature  = $_POST['signature'];

$received_public_key = $parsed_data['public_key'];
$order_id            = $parsed_data['order_id'];
$status              = $parsed_data['status'];
$sender_phone        = $parsed_data['sender_phone'];
$amount              = $parsed_data['amount'];
$currency            = $parsed_data['currency'];
$transaction_id      = $parsed_data['transaction_id'];

$real_order_id = explode('#', $order_id);
$real_order_id = $real_order_id[0];

if ($real_order_id <= 0) { die(); }
if (!($arOrder = CSaleOrder::GetByID($real_order_id))) { die(); }
if ($arOrder['PAYED'] == 'Y') { die(); }

CSalePaySystemAction::InitParamArrays($arOrder, $arOrder['ID']);

$private_key = CSalePaySystemAction::GetParamValue('PRIVATE_KEY');
$public_key  = CSalePaySystemAction::GetParamValue('PUBLIC_KEY');

$generated_signature = base64_encode(sha1($private_key.$data.$private_key, 1));

if ($received_signature != $generated_signature || $public_key != $received_public_key) { die(); }

if ($status == 'success') {
    //here you can update your order
    $sDescription = '';
    $sStatusMessage = '';

    $sDescription .= 'sender phone: '.$sender_phone.'; ';
    $sDescription .= 'amount: '.$amount.'; ';
    $sDescription .= 'currency: '.$currency.'; ';

    $sStatusMessage .= 'status: '.$status.'; ';
    $sStatusMessage .= 'transaction_id: '.$transaction_id.'; ';
    $sStatusMessage .= 'order_id: '.$real_order_id.'; ';

    $arFields = array(
        'PS_STATUS' => 'Y',
        'PS_STATUS_CODE' => $status,
        'PS_STATUS_DESCRIPTION' => $sDescription,
        'PS_STATUS_MESSAGE' => $sStatusMessage,
        'PS_SUM' => $amount,
        'PS_CURRENCY' => $currency,
        'PS_RESPONSE_DATE' => date(CDatabase::DateFormatToPHP(CLang::GetDateFormat('FULL', LANG))),
    );

    CSaleOrder::PayOrder($arOrder['ID'], 'Y');
    CSaleOrder::Update($arOrder['ID'], $arFields);
}
