<?php
/**
 * MQLocale
 * Copyright (c) 2014 Milq Media.
 *
 * @author      Johan Kuijt <johan@milq.nl>
 * @copyright   2014 Milq Media.
 * @license     http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link        http://milq.nl
 */

namespace MQLocale\Locale;

class DetectorConfig
{	
    /**
     * Default locale
     *
     * @var string
     */
    protected $default;

    /**
     * List of supported locales
     *
     * @var array
     */
    protected $supported;
    
    /**
     * Lis of supported domains
     *
     * @var array
     */
    protected $domains;
    
    /**
     * List of supported aliases
     *
     * @var array
     */
    protected $aliases;
    
    /**
     * Strategy
     *
     * @var string
     */
    protected $strategy;


    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }
    
    public function getSupported()
    {
        return $this->supported;
    }
    
    public function setSupported(array $supported)
    {
        $this->supported = $supported;
        return $this;
    }
    
    public function hasSupported()
    {
        return (is_array($this->supported) && count($this->supported));
    }
    
    public function getDomains()
    {
        return $this->domains;
    }
    
    public function setDomains(array $domains)
    {
        $this->domains = $domains;
        return $this;
    }
    
    public function getAliases()
    {
        return $this->aliases;
    }
    
    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
        return $this;
    }
    
    public function getStrategy()
    {
        return $this->strategy;
    }
    
    public function setStrategy($strategy)
    {
        $this->strategy = (string) $strategy;
        return $this;
    }
    
    public function hasStrategy()
    {
        return !empty($this->strategy);
    }
}
