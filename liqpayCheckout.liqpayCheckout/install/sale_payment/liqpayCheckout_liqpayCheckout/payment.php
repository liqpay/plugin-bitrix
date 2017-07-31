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
	include(GetLangFileName(dirname(__FILE__).'/', '/payment.php'));

	$order_id = (strlen(CSalePaySystemAction::GetParamValue('ORDER_ID')) > 0)
		? CSalePaySystemAction::GetParamValue('ORDER_ID')
		: $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['ID'];

	$amount = (strlen(CSalePaySystemAction::GetParamValue('AMOUNT')) > 0)
		? CSalePaySystemAction::GetParamValue('AMOUNT')
		: $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['SHOULD_PAY'];

	$currency = (strlen(CSalePaySystemAction::GetParamValue('CURRENCY')) > 0)
		? CSalePaySystemAction::GetParamValue('CURRENCY')
		: $GLOBALS['SALE_INPUT_PARAMS']['ORDER']['CURRENCY'];

	$result_url  = CSalePaySystemAction::GetParamValue('RESULT_URL');
	$server_url  = CSalePaySystemAction::GetParamValue('SERVER_URL');
	$public_key  = CSalePaySystemAction::GetParamValue('PUBLIC_KEY');
    $private_key = CSalePaySystemAction::GetParamValue('PRIVATE_KEY');
	$type        = 'buy';
    $description = 'Order #'.$order_id;
    $order_id   .= '#'.time();
    $language    = LANGUAGE_ID;
    $version     = '3';
    $action      = 'pay';

	if ($currency == 'RUR') { $currency = 'RUB'; }

    $data = base64_encode(
                    json_encode(
                            array('version'     => $version,
                                  'public_key'  => $public_key,
                                  'amount'      => $amount,
                                  'currency'    => $currency,
                                  'description' => $description,
                                  'order_id'    => $order_id,
                                  'type'        => $type,
                                  'action'      => $action,
                                  'result_url'  => $result_url,
                                  'server_url'  => $server_url,
                                  'language'    => $language)
                                )
                            );
	
	$signature = '';
	if (isset($private_key)) {
        $signature = base64_encode(sha1($private_key.$data.$private_key, 1));
	}

    if (!$action = CSalePaySystemAction::GetParamValue('ACTION')) {
        $action = 'https://www.liqpay.ua/api/3/checkout';
    }
?>

<?=GetMessage('PAYMENT_DESCRIPTION_PS')?> <b>www.liqpay.ua</b>.<br /><br />
<?=GetMessage('PAYMENT_DESCRIPTION_SUM')?>: <b><?=CurrencyFormat($amount, $currency)?></b><br /><br />

<form method="POST" action="<?=$action?>" accept-charset="utf-8">
    <input type="hidden" name="signature" value="<?=$signature?>" />
    <input type="hidden" name="data" value="<?=$data?>" />
    <input type="image" src="//static.liqpay.ua/buttons/p1ru.radius.png" />
</form>