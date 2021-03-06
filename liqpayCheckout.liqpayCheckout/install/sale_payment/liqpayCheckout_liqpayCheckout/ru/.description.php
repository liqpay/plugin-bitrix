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

global $MESS;
$MESS['LP_MODULE_NAME'] = 'Платежная система LiqpayCheckout';
$MESS['LP_MODULE_DESC'] = 'Обработчик для платежной системы LiqpayCheckout';
$MESS['LP_PUBLIC_KEY'] = 'Публичный ключ';
$MESS['LP_PUBLIC_KEY_DESC'] = '(идентификатор магазина, <a target="_blank" href="https://www.liqpay.ua/admin/business">получить публичный ключ</a>)';
$MESS['LP_AMOUNT'] = 'Сумма для списания при оплате в магазине';
$MESS['LP_CURRENCY'] = 'Валюта платежа';
$MESS['LP_ORDER_ID'] = 'Уникальный ID покупки в Вашем магазине';
$MESS['LP_RESULT_URL'] = 'URL на который будет переадресация после покупки';
$MESS['LP_RESULT_URL_DESC'] = '(этот параметр можно указать единоразово в настройках магазина)';
$MESS['LP_SERVER_URL'] = 'URL API для уведомлений о статусе покупки';
$MESS['LP_SERVER_URL_DESC'] = '(этот параметр можно указать единоразово в настройках магазина)';
$MESS['LP_TYPE'] = 'Action';
$MESS['LP_TYPE_DESC'] = '(подробнее о возможных значениях этого параметра <a target="_blank" href="https://www.liqpay.ua/documentation/ru"></a>)';
$MESS['LP_PRIVATE_KEY'] = 'Приватный ключ';
$MESS['LP_PRIVATE_KEY_DESC'] = '(<a target="_blank" href="https://www.liqpay.ua/admin/business">получить приватный ключ</a>)';
$MESS['LP_ACTION'] = 'URL Liqpay API';
$MESS['LP_ACTION_DESC'] = '(атрибут action формы для приема платежей)';


