<?php

namespace Acommerce\Address\Controller\Adminhtml\Importaddress;

class SampleCsv extends \Acommerce\Address\Controller\Adminhtml\ExportCsv
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\File\Csv $csvWriter,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList
    ) {
        parent::__construct($context, $resultRawFactory, $fileFactory, $csvWriter, $directoryList);
    }

    public function execute()
    {
        if ($csvType = $this->getRequest()->getParam('code')){
            $fileDirectory = \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR;
            $fileName = 'sample_'.$csvType.'.csv';
            $filePath =  $this->directoryList->getPath($fileDirectory) . "/" . $fileName;

            $data = [];

            switch ($csvType) {
                case 'region':
                    $data[] = ['country_id','code','default_name'];
                    $data[] = ['ID','ID-BA','Bali'];
                    $data[] = ['ID','ID-BB','Bangka Belitung'];
                    break;
                case 'city':
                    $data[] = ['region_code','city_name'];
                    $data[] = ['ID-AC','Kota Banda Aceh'];
                    $data[] = ['ID-AC','Kota Langsa'];
                    break;
                case 'subdistrict':
                    $data[] = ['region','city','subdistrict','postcode'];
                    $data[] = ['Bali','Kab. Badung','Abiansemal','1234,2345'];
                    $data[] = ['Bali','Kab. Badung','Kuta','1234,2345,5678'];
                    break;
            }

            $this->csvWriter->saveData($filePath ,$data);
            $this->fileFactory->create(
                $fileName,
                [
                    'type'  => "filename",
                    'value' => $fileName,
                    'rm'    => true,
                ],
                \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
                'text/csv',
                null
            );

            $resultRaw = $this->resultRawFactory->create();
            return $resultRaw;
        } else {
            $this->_redirect('*/*');
        }
    }
}
