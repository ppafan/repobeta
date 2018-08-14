<?php
/**
 * Copyright © 2017 Acommerce. All rights reserved.
 */

namespace Acommerce\Address\Controller\Adminhtml\Importaddress;

class Save extends \Magento\Backend\App\Action
{
    protected $csvProcessor;
    protected $resource;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        parent::__construct($context);
        $this->csvProcessor = $csvProcessor;
        $this->resource = $resource;
    }

    public function execute()
    {
        if ($postdata = $this->getRequest()->getPostValue()){
            try {
                $connection = $this->resource->getConnection();
                $select = $connection->select()->from(['dcr' => 'directory_country_region'], ['region_id','code'])->where('country_id = ?', $postdata['country_id']);
                $country_region = $connection->fetchAll($select);
                $regions = [];
                foreach ($country_region as $reg) {
                    $regions[$reg['code']] = $reg['region_id'];
                }

                if (!empty($_FILES['import_address']['tmp_name'])) {
                    $importRawData = iterator_to_array($this->_prepareData($_FILES['import_address']['tmp_name']));
                    switch ($postdata['import_type']) {
                        case 0:
                            $this->_importRegion($importRawData);
                            break;
                        case 1:
                            $this->_importCity($regions, $importRawData);
                            break;
                        case 2:
                            $this->_importSubdistrict($importRawData);
                            break;
                    }
                    $this->messageManager->addSuccess(__('Address has been imported.'));
                    $this->_redirect('*/*');
                    return;
                } else {
                    $this->messageManager->addError(__('Import file containt error. Please try again.'));
                    $this->_redirect('*/*');
                    return;
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError(
                    __('Something went wrong while saving the data. Please review the error log.')
                );
                $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);
                $this->_redirect('*/*');
                return;
            }
        }
        $this->_redirect('*/*');
    }

    protected function _prepareData($file)
    {
        $importRawData = $this->csvProcessor->getData($file);
        for($i=1; $i<count($importRawData); $i++) {
            yield $importRawData[$i];
        }
    }

    protected function _importRegion($importRawData)
    {
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('directory_country_region');
        $insert = [];
        foreach ($importRawData as $data) {
            $select = $connection->select()
                        ->from(['dcr' => $table], 'COUNT(*)')
                        ->where('country_id = ?', $data[0])
                        ->where('code = ?', $data[1]);
            $count = $connection->fetchOne($select);
            if($count > 0){
                $update = ['default_name' => $data[2]];
                $where = ['country_id = ?' => $data[0],'code = ?' => $data[1]];
                $connection->update($table, $update, $where);
            } else {
                $insert[] = ['country_id' => $data[0], 'code' => $data[1], 'default_name' => $data[2]];
            }
        }
        if(count($insert) > 0){
            $connection->insertMultiple($table, $insert);
        }
    }

    protected function _importCity($regions, $importRawData)
    {
        $connection = $this->resource->getConnection();
        $table = $this->resource->getTableName('directory_country_region_city');
        $insert = [];
        foreach ($importRawData as $data) {
            $select = $connection->select()->from(['dcrc' => $table], 'COUNT(*)')->where('default_name = ?', $data[1]);
            $count = $connection->fetchOne($select);
            if($count > 0){
                $update = ['default_name' => $data[1]];
                $where = ['region_id = ?' => $regions[$data[0]]];
                $connection->update($table, $update, $where);
            } else {
                $insert[] = ['default_name' => $data[1], 'region_id' => $regions[$data[0]]];
            }
        }
        if(count($insert) > 0){
            $connection->insertMultiple($table, $insert);
        }
    }

    protected function _importSubdistrict($importRawData)
    {
        $connection = $this->resource->getConnection();
        $regionTable = $this->resource->getTableName('directory_country_region');
        $cityTable = $this->resource->getTableName('directory_country_region_city');
        $subdistrictTable = $this->resource->getTableName('directory_country_region_city_subdistrict');
        $insert = [];
        foreach ($importRawData as $data) {
            $select = $connection->select()
                                ->from(['dcrc' => $cityTable], ['city_id'])
                                ->joinLeft(
                                    ['dcr' => $regionTable],
                                    'dcrc.region_id = dcr.region_id',
                                    []
                                )
                                ->where('dcr.default_name = ?', $data[0])
                                ->where('dcrc.default_name = ?', $data[1]);

            $city_id = $connection->fetchOne($select);
            if($city_id){
                $query = $connection->select()->from(['dcrcs' => $subdistrictTable], 'COUNT(*)')->where('city_id = ?', $city_id);
                $count = $connection->fetchOne($query);
                if($count > 0){
                    $update = ['default_name' => $data[2],'postcode' => $data[3]];
                    $where = ['city_id = ?' => $city_id];
                    $connection->update($subdistrictTable, $update, $where);
                } else {
                    $insert[] = ['city_id' => $city_id, 'default_name' => $data[2], 'postcode' => $data[3]];
                }
            }
        }
        if(count($insert) > 0){
            $connection->insertMultiple($subdistrictTable, $insert);
        }
    }

    /**
     * Determine if authorized to perform group actions.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Acommerce_Address::import_address');
    }
}
