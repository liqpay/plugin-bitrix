<?php
IncludeModuleLangFile(__FILE__);

class liqpay_liqpay extends CModule
{
    public $MODULE_ID = 'liqpay.liqpay';
    public $MODULE_GROUP_RIGHTS = 'N';

    public $PARTNER_NAME = 'www.liqpay.com';
    public $PARTNER_URI = 'http://www.liqpay.com';

    public function __construct()
    {
        require(dirname(__FILE__).'/version.php');

        $this->MODULE_NAME = GetMessage('LP_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('LP_MODULE_DESC');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
    }

    public function DoInstall()
    {
        if (IsModuleInstalled('sale')) {
            global $APPLICATION;
            $this->InstallFiles();
            RegisterModule($this->MODULE_ID);
            return true;
        }

        $MODULE_ID = $this->MODULE_ID;
        $TAG = 'VWS';
        $MESSAGE = GetMessage('LP_ERR_MODULE_NOT_FOUND', array('#MODULE#'=>'sale'));
        $intID = CAdminNotify::Add(compact('MODULE_ID', 'TAG', 'MESSAGE'));

        return false;
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        COption::RemoveOption($this->MODULE_ID);
        UnRegisterModule($this->MODULE_ID);
        $this->UnInstallFiles();
    }

    public function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$this->MODULE_ID.'/install/sale_payment',
            $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/sale_payment',
            true, true
        );
    }

    public function UnInstallFiles()
    {
        return DeleteDirFilesEx($_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/include/sale_payment/liqpay_liqpay');
    }
}