<?php

namespace RightpointAssignment\SalesOrderAdminCustamization\Controller\Adminhtml\FormController;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use RightpointAssignment\SalesOrderAdminCustamization\Model\AddistionalDetailFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

class SubmitOnclick extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    protected $addistionaldetailFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param AddistionalDetailFactory $addistionaldetailFactory
     */
    public function __construct(
        Context                  $context,
        PageFactory              $resultPageFactory,
        AddistionalDetailFactory $addistionaldetailFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->addistionaldetailFactory = $addistionaldetailFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getPostValue();
            if ($data) {
                $Shippingmethod = $data['shipping_method'];
                $Merchantnote = $data['merchant_note'];
                $Shippingdate = $data['shipping_date'];
                $insertData = $this->addistionaldetailFactory->create();
                $insertData->setShippingMethod($Shippingmethod)
                    ->setMerchantNote($Merchantnote)
                    ->setShippingDate($Shippingdate)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        }catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('sales/order/view');
    }
}
