<?php

namespace Modules\Base\Support\Locale;

trait LocaleTrait
{
    public function attributesToArrayWithLocale($locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        $localePrefix = $this->localePrefix();

        $localeAttributes = $this->localeAttributes();

        $attributes = parent::attributesToArray();

        foreach ($localeAttributes as $k) {
            $attributes[$k . '_' . $locale] = __($localePrefix . $attributes[$k]);
        }

        return $attributes;
    }

    /**
     * 需要进行本地化翻译的属性
     * @return array
     */
    public function localeAttributes()
    {
        return property_exists($this, 'localeAttributes') ? $this->localeAttributes : [];
    }

    /**
     * 语言包
     * @return string
     */
    public function localePrefix()
    {
        return property_exists($this, 'localePrefix') ? $this->localePrefix : '';
    }
}
