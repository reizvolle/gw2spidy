<?php

namespace GW2Spidy\Twig;

use GW2Spidy\Util\Functions;

class GenericHelpersExtension extends \Twig_Extension {
    public function getFilters() {
        return array(
            'round' => new \Twig_Filter_Method($this, 'round'),
            'ceil' => new \Twig_Filter_Method($this, 'ceil'),
            'floor' => new \Twig_Filter_Method($this, 'floor'),
            'rarity_css_class' => new \Twig_Filter_Method($this, 'rarity_css_class'),
            'slugify' => new \Twig_Filter_Method($this, 'slugify'),
            'clean_whitespace' => new \Twig_Filter_Method($this, 'clean_whitespace'),
            'karma' => new \Twig_Filter_Method($this, 'karma',  array('is_safe' => array('html'))),
            'age' => new \Twig_Filter_Method($this, 'age'),
        );
    }
    public function getFunctions() {
        return array(
            'now' => new \Twig_Function_Method($this, 'now'),
        );
    }

    public function slugify($str) {
        return Functions::slugify($str);
    }

    public function floor($num) {
        return floor($num);
    }

    public function round($num) {
        return round($num);
    }

    public function ceil($num) {
        return ceil($num);
    }

    public function now($format = "Y-m-d H:i:s") {
        return date($format);
    }

    public function rarity_css_class($rarity) {
        return strtolower("rarity-" . str_replace(" ", "-", $rarity));
    }

    public function clean_whitespace($str) {
        return trim(preg_replace('/\n /', "\n", preg_replace('/ +/', ' ', $str)));
    }

    public function karma($karma, $nonnull = false) {
        if($nonnull && !$karma) return '';

        return number_format($karma) . ' <img alt="Karma" src="/assets/img/Karma.png" height="15" width="18">';
    }

    public function age($datetime) {
        $difference = time() - strtotime($datetime);
        $periods = array("second", "minute", "hour", "day");
        $lengths = array(60, 60, 24, 7);
        for($j = 0; $j < 3 && $difference >= $lengths[$j]; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);

        if($difference != 1) {
            $periods[$j] .= "s";
        }
        return "$difference $periods[$j] ago";
    }

    public function getName() {
        return 'generic_helpers';
    }
}
