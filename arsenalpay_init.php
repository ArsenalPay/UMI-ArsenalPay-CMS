<?php

$className   = "arsenalpay";
$paymentName = "ArsenalPay";

include "standalone.php";

$objectTypesCollection = umiObjectTypesCollection::getInstance();
$objectsCollection     = umiObjectsCollection::getInstance();


// получаем родительский тип
$parentTypeId = $objectTypesCollection->getTypeIdByGUID("emarket-payment");

// Тип для внутреннего объекта, связанного с публичным типом
$internalTypeId = $objectTypesCollection->getTypeIdByGUID("emarket-paymenttype");
$typeId         = $objectTypesCollection->addType($parentTypeId, $paymentName);

// Создаем внутренний объект
$internalObjectId = $objectsCollection->addObject($paymentName, $internalTypeId);
$internalObject   = $objectsCollection->getObject($internalObjectId);
$internalObject->setValue("class_name", $className); // имя класса для реализации

// связываем его с типом
$internalObject->setValue("payment_type_id", $typeId);
$internalObject->setValue("payment_type_guid", "emarket-payment-" . $className);
$internalObject->commit();

// Связываем внешний тип и внутренний объект
$type = $objectTypesCollection->getType($typeId);

$fieldTypesCollection = umiFieldTypesCollection::getInstance();
$typeString           = $fieldTypesCollection->getFieldTypeByDataType('string');

$fieldsCollection = umiFieldsCollection::getInstance();


$fieldsIdArray   = array();
$fieldsIdArray[] = $fieldsCollection->addField('callback_key', 'callbackKey', $typeString->getId(), 1, 0, 0);
$fieldsIdArray[] = $fieldsCollection->addField('widget_key', 'widgetKey', $typeString->getId(), 1, 0, 0);
$fieldsIdArray[] = $fieldsCollection->addField('widget_id', 'widget', $typeString->getId(), 1, 0, 0);

$groupId = $type->addFieldsGroup('settings', 'Параметры', 1, 1);
$group   = $type->getFieldsGroup($groupId);

foreach ($fieldsIdArray as $fieldId) {
	$field = $fieldsCollection->getField($fieldId);
	$field->setIsRequired(1);
	$field->setIsVisible(1);
	$field->setIsInFilter(0);
	$field->setIsInSearch(0);
	$group->attachField($fieldId);
}

$ipAddressFieldId = $fieldsCollection->addField('ip_address', 'IP address', $typeString->getId(), 1, 0, 0);
$ipAddressField = $fieldsCollection->getField($ipAddressFieldId);
$ipAddressField->setIsRequired(0);
$ipAddressField->setIsVisible(1);
$ipAddressField->setIsInFilter(0);
$ipAddressField->setIsInSearch(0);
$group->attachField($ipAddressFieldId);

$type->setGUID($internalObject->getValue("payment_type_guid"));
$type->commit();

echo "Готово!";


?>
