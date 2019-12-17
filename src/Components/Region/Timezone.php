<?php
namespace Astronphp\Components\Region;

class Timezone
{
    /**
     * this var save locale for framework, see more: https://www.php.net/manual/pt_BR/locale.setdefault.php
     *
     * @var string
     */
    private $locale = 'pt-BR';
    /**
     * this var save dateTimezone for framework, see more: https://www.php.net/manual/pt_BR/class.datetimezone.php
     *
     * @var string
     */
    private $dateTimezone = 'America/Sao_Paulo';

    public function __construct(array $conf = [])
    {
        if (isset($conf['locale'])) {
            $this->setLocale($conf['locale']);
        }
        if (isset($conf['date_timezone'])) {
            $this->setDateTimezone($conf['date_timezone']);
        }
        return $this;
    }
    
    /**
     * build all configurations
     *
     * @return boolean
     */
    public function build()
    {
        return (
                ($this->defineLocale()==$this->getLocale()) &&
                ($this->defineDateTimezone()==$this->getDateTimezone())
        );
    }
    
    /**
     * define localdefault equals ini_set('intl.default_locale', 'pt-BR');
     *
     * @return void
     */
    public function defineLocale()
    {
        \Locale::setDefault($this->getLocale());
        return \Locale::getDefault();
    }
    
    /**
      * define timezone equals date_default_timezone_set
     *
     * @return date_default_timezone_get
     */
    public function defineDateTimezone()
    {
        date_default_timezone_set($this->getDateTimezone());
        return date_default_timezone_get($this->getDateTimezone());
    }

    /**
     * return var locale
     *
     * @return void
     */
    public function getLocale()
    {
        return $this->locale;
    }
    /**
     * Undocumented function
     *
     * @param [type] $locale
     * @return void
     */
    public function setLocale(string $locale='')
    {
        if(!empty($locale)){
            $this->locale = $locale;
        }
        return $this;
    }

    /**
     * return var dateTimezone
     *
     * @return void
     */
    public function getDateTimezone()
    {
        return $this->dateTimezone;
    }
    /**
     * Undocumented function
     *
     * @param [type] $dateTimezone
     * @return void
     */
    public function setDateTimezone(string $dateTimezone = '')
    {
        if(!empty($dateTimezone)){
            $this->dateTimezone = $dateTimezone;
        }
        return $this;
    }
}