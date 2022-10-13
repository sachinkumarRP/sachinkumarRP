<?php
declare(strict_types=1);

namespace RightpointAssignment\CustomerInputGraphql\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Mag\CustomForm\Model\CustomFormCheck;
use Rightpoint\Test\Model\ContactFactory;
use Rightpoint\Test\Model\ResourceModel\Contact\CollectionFactory;
use Magento\Framework\Validator\EmailAddress as EmailValidator;

class CustomerAddDb implements ResolverInterface
{
    /**
     * @var ContactFactory
     * @var CollectionFactory
     * @var EmailValidator
     */
    protected $contactFactory;
    protected $collectionFactory;
    protected $emailValidator;

    /**
     * @param ContactFactory $contactFactory
     * @param CollectionFactory $collectionFactory
     * @param EmailValidator $emailValidator
     */
    public function __construct(
        ContactFactory $contactFactory,
        CollectionFactory $collectionFactory,
        EmailValidator $emailValidator
    ) {
        $this->contactFactory = $contactFactory;
        $this->collectionFactory = $collectionFactory;
        $this->emailValidator = $emailValidator;
    }

    /**
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return array
     * @throws GraphQlInputException
     */
    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        if (empty($args['input']['name']))
        {
            throw new GraphQlInputException(__('Name is missing'));
        } elseif ((preg_match('/[^A-Za-z]/', $args['input']['name']))){
            throw new GraphQlInputException(__('Name is invalid'));
        } elseif (empty($args['input']['email'])){
            throw new GraphQlInputException(__('Email is missing'));
        } elseif (!$this->emailValidator->isValid($args['input']['email'])){
            throw new GraphQlInputException(__('Email is invalid'));
        } elseif (strlen($args['input']['phone_number']) !== 10){
            throw new GraphQlInputException(__('MobileNumber is invalid'));
        }

        $email= $args['input']['email'];
        $name = $args['input']['name'];
        $mobile= $args['input']['phone_number'];
        $customerEmail = $this->contactFactory->create()
            ->getCollection()
            ->addFieldToFilter('email', $email)
            ->load();
        if ($customerEmail->count()){
            throw new GraphQlInputException(__('Customer Already Existes'));
        }else {
            $customerEmail = $this->contactFactory->create();
            $customerEmail->setName($name)
                ->setPhoneNumber($mobile)
                ->setEmail($email)->save();
        }
        $result = $this->GetCutomerData($email);
        return [
            'id'=> $result[0]['id'],
            'name'=> $result[0]['name'],
            'email'=> $result[0]['email'],
            'phone_number'=> $result[0]['phone_number']
        ];
    }

    /**
     * @param $email
     * @return array
     */
    public function GetCutomerData($email)
    {
        $customers = $this->collectionFactory->create()
            ->addFieldToFilter('email', $email);
        $customerInfo = [];
        foreach ($customers as $customer) {
            $customerInfo[] = [
                'name' => $customer->getName(),
                'id' => $customer->getId(),
                'email' => $customer->getEmail(),
                'phone_number' => $customer->getPhoneNumber()
            ];
        }
        return $customerInfo;
    }
}
