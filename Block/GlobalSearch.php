<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magecrafts\AdminSearch\Block;

use Magento\Backend\Model\GlobalSearch\SearchEntityFactory;
use Magento\Backend\Model\GlobalSearch\SearchEntity;
use Magento\Framework\App\ObjectManager;

/**
 * @api
 * @since 100.0.2
 */
class GlobalSearch extends \Magento\Backend\Block\GlobalSearch
{

    /**
     * @var string
     */
    protected $_template = 'Magento_Backend::system/search.phtml';



    /**
     * Get components configuration
     * @return array
     */
    public function getWidgetInitOptions()
    {
        return [
            'Magecrafts_AdminSearch/js/suggest' => [
                'dropdownWrapper' => '<div class="autocomplete-results" ></div >',
                'template' => '[data-template=search-suggest]',
                'termAjaxArgument' => 'query',
                'source' => $this->getUrl('adminhtml/index/globalSearch'),
                'filterProperty' => 'name',
                'preventClickPropagation' => false,
                'minLength' => 5,
            ]
        ];
    }

}
