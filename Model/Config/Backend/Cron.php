<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Smtp\Model\Config\Backend;

use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ValueFactory;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Model\Context;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Cron\Model\Config\Source\Frequency;

/**
 * Cron Config Value
 */
class Cron extends ConfigValue
{
    /**
     * Cron String Constant
     */
    const CRON_STRING_PATH = 'crontab/default/jobs/faonni_smtp_clean_log/schedule/cron_expr';
    
    /**
     * Cron Model Constant
     */
    const CRON_MODEL_PATH = 'crontab/default/jobs/faonni_smtp_clean_log/run/model';
    
    /**
     * Enabled Log Cleaning Config Path
     */
    const XML_PATH_CLEAN_ENABLED = 'groups/smtp/fields/clean/value';
    
    /**
     * Start Time Config Path
     */
    const XML_PATH_CLEAN_TIME = 'groups/smtp/fields/time/value';
    
    /**
     * Frequency Config Path
     */
    const XML_PATH_CLEAN_FREQUENCY = 'groups/smtp/fields/frequency/value';

    /**
     * Config Value Factory
     *
     * @var \Magento\Framework\App\Config\ValueFactory
     */    
    protected $_configValueFactory;

    /**
     * Run Model Path
     *
     * @var string
     */ 
    protected $_runModelPath = '';

    /**
	 * Initialize Model
	 *
     * @param Context $context
     * @param Registry $registry
     * @param ScopeConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     * @param ValueFactory $configValueFactory
     * @param AbstractResource $resource
     * @param AbstractDb $resourceCollection
     * @param string $runModelPath
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        ValueFactory $configValueFactory,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        $runModelPath = '',
        array $data = []
    ) {
        $this->_runModelPath = $runModelPath;
        $this->_configValueFactory = $configValueFactory;
        
        parent::__construct(
            $context, 
            $registry, 
            $config, 
            $cacheTypeList, 
            $resource, 
            $resourceCollection, 
            $data
        );
    }

    /**
     * Cron Settings Save
     *
     * @return \Faonni\Smtp\Model\Config\Backend\Cron
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterSave()
    {
        $enabled = $this->getData(self::XML_PATH_CLEAN_ENABLED);
        $time = $this->getData(self::XML_PATH_CLEAN_TIME);
        $frequency = $this->getData(self::XML_PATH_CLEAN_FREQUENCY);

        $frequencyWeekly = Frequency::CRON_WEEKLY;
        $frequencyMonthly = Frequency::CRON_MONTHLY;

        if ($enabled) {
            $cronExprArray = [
                intval($time[1]),                                 # Minute
                intval($time[0]),                                 # Hour
                $frequency == $frequencyMonthly ? '1' : '*',      # Day of the Month
                '*',                                              # Month of the Year
                $frequency == $frequencyWeekly ? '1' : '*',        # Day of the Week
            ];
            $cronExprString = join(' ', $cronExprArray);
        } else {
            $cronExprString = '';
        }

        try {
            $this->_configValueFactory->create()->load(
                self::CRON_STRING_PATH,
                'path'
            )->setValue(
                $cronExprString
            )->setPath(
                self::CRON_STRING_PATH
            )->save();

            $this->_configValueFactory->create()->load(
                self::CRON_MODEL_PATH,
                'path'
            )->setValue(
                $this->_runModelPath
            )->setPath(
                self::CRON_MODEL_PATH
            )->save();
        } 
        catch (\Exception $e) {
            throw new LocalizedException(
                __('We can\'t save the Cron expression.')
            );
        }
        return parent::afterSave();
    }
}
