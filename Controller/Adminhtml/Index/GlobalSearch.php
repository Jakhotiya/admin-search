<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magecrafts\AdminSearch\Controller\Adminhtml\Index;

/**
 * @api
 * @since 100.0.2
 */
class GlobalSearch extends \Magento\Backend\Controller\Adminhtml\Index\GlobalSearch
{
    /**
     * Global Search Action
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $items = [];

        if (!$this->_authorization->isAllowed('Magento_Backend::global_search')) {
            $items[] = [
                'id' => 'error',
                'type' => __('Error'),
                'name' => __('Access Denied.'),
                'description' => __('You need more permissions to do this.'),
            ];
        } else {
            if (empty($this->_searchModules)) {
                $items[] = [
                    'id' => 'error',
                    'type' => __('Error'),
                    'name' => __('No search modules were registered'),
                    'description' => __(
                        'Please make sure that all global admin search modules are installed and activated.'
                    ),
                ];
            } else {
                $start = $this->getRequest()->getParam('start', 1);
                $limit = $this->getRequest()->getParam('limit', 10);
                $query = $this->getRequest()->getParam('query', '');
                $entity = $this->getRequest()->getParam('entity');
                foreach ($this->_searchModules as $type => $searchConfig) {
                    if ($searchConfig['acl'] && !$this->_authorization->isAllowed($searchConfig['acl'])) {
                        continue;
                    }

                    if($entity && $entity!==$type){
                        continue;
                    }

                    $className = $searchConfig['class'];
                    if (empty($className)) {
                        continue;
                    }
                    $searchInstance = $this->_objectManager->create($className);
                    $results = $searchInstance->setStart(
                        $start
                    )->setLimit(
                        $limit
                    )->setQuery(
                        $query
                    )->load()->getResults();
                    $items = array_merge_recursive($items, $results);
                }
            }
        }

        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($items);
    }
}
