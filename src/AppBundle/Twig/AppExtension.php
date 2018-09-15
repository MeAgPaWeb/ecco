<?php

// src/AppBundle/Twig/AppExtension.php
namespace AppBundle\Twig;

use AppBundle\Entity\User;

class AppExtension extends \Twig_Extension
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var SymfonyComponentDependencyInjectionContainerInterface
     */
    protected $container;

    /**
     * Available locales
     */
    private $locales;

    private $parameters;

    public function __construct($container = null, $request, $locale, $media, $security)
    {
        $this->container = $container;
        $this->request = $request;
        $this->locales = array('en', 'es');
        $this->parameters = array('locale' => $locale, 'media' => $media, 'security' => $security);
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('locale_date', array($this, 'localeDate')),
            new \Twig_SimpleFilter('gender', array($this, 'gender')),
            new \Twig_SimpleFilter('role', array($this, 'role')),
            new \Twig_SimpleFilter('url', array($this, 'url')),
        );
    }

    public function gender($gender, $locale = null)
    {
        $locale = ($locale == null)?$this->parameters['locale']:$locale;
        if (!in_array($locale, $this->locales)) {
            return $gender;
        }

        $gender_long['en'] = array(
            'Male',
            'Female'
        );

        $gender_long['es'] = array(
            'Masculino',
            'Femenino'
        );

        $gender_short['en'] = array(
            'M',
            'F'
        );

        $gender_short['es'] = array(
            'M',
            'F'
        );

        $gender = str_replace($gender_long["en"], $gender_long[$locale], $gender);
        $gender = str_replace($gender_short["en"], $gender_short[$locale], $gender);
        return $gender;
    }

    public function localeDate($date, $format, $locale = null)
    {
        $locale = ($locale == null)?$this->parameters['locale']:$locale;
        if (!in_array($locale, $this->locales)) {
            return $gender;
        }

        $month_long["en"] = array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        );

        $month_long["es"] = array(
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        );

        $weekday_long["en"] = array(
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        );

        $weekday_long["es"] = array(
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sábado',
            'Domingo'
        );

        $weekday_short["en"] = array(
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun'
        );

        $weekday_short["es"] = array(
            'Lun',
            'Mar',
            'Mie',
            'Jue',
            'Vie',
            'Sab',
            'Dom'
        );

        $fecha = date($format, $date);
        $fecha = str_replace($month_long["en"], $month_long[$locale], $fecha);
        $fecha = str_replace($weekday_long["en"], $weekday_long[$locale], $fecha);
        $fecha = str_replace($weekday_short["en"], $weekday_short[$locale], $fecha);

        return $fecha;
    }

    public function role($role, $locale = null) {
        /*if (in_array("ROLE_ADMIN", $role)) {
            $role = "ROLE_ADMIN";
        } else {
            $role = "ROLE_USER";
        }*/

        $locale = ($locale == null)?$this->parameters['locale']:$locale;
        if (!in_array($locale, $this->locales)) {
            return $role;
        }

        if (is_array($role)) {
            unset($role[count($role)-1]);
            $role = implode(", ", $role);
        }

        $roles['sys'] = array(
            'ROLE_ADMIN',
            'ROLE_SUPERVISOR',
            'ROLE_CHIEF',
            'ROLE_ADVERTISING',
            'ROLE_COLUMNIST',
            'ROLE_COLUMN_EDITOR',
            'ROLE_EDITOR',
            'ROLE_VISITOR'
        );

        $roles['en'] = array(
            'Administrator',
            'Supervisor',
            'Chief Editor',
            'Advertising',
            'Columnist',
            'Columnist Editor',
            'Notes Editor',
            'Visitor'
        );

        $roles['es'] = array(
            'Administrador',
            'Supervisor',
            'Jefe de Redacción',
            'Publicidades',
            'Columnista',
            'Editor de Columnas',
            'Editor de Notas',
            'Visitante'
        );

        $role = str_replace($roles["sys"], $roles[$locale], $role);
        return $role;
    }

    public function url($url) {
        $url = strtolower($url);
        $url = str_replace(' ', '-', $url);
        return preg_replace('/[^A-Za-z0-9\-]/', '', $url);
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('security_granted', array($this, 'securityGranted')),
            new \Twig_SimpleFunction('aspect_ratio', array($this, 'aspectRatio')),
            new \Twig_SimpleFunction('media_asset', array($this, 'mediaAsset')),
            new \Twig_SimpleFunction('avatar_asset', array($this, 'avatarAsset')),
            new \Twig_SimpleFunction('get_route', array($this, 'getRoute')),
            new \Twig_SimpleFunction('get_route_root', array($this, 'getRouteRoot')),
            new \Twig_SimpleFunction('is_route', array($this, 'isRoute')),
            new \Twig_SimpleFunction('is_route_root', array($this, 'isRouteRoot')),
            new \Twig_SimpleFunction('is_graphic_notifications', array($this, 'isGraphicNotifications')),
            new \Twig_SimpleFunction('is_sound_notifications', array($this, 'isSoundNotifications')),
            new \Twig_SimpleFunction('is_lighttheme', array($this, 'isLightTheme')),
            new \Twig_SimpleFunction('get_theme', array($this, 'getTheme')),
            new \Twig_SimpleFunction('is_current_theme', array($this, 'isCurrentTheme')),
        );
    }

    public function securityGranted($user, $access, $any = true) {
        $roles      = $user->getRoles();
        $security   = $this->parameters['security'];
        $target     = $security['access'];
        $pre_target = $target;

        $target_found = true;
        $granted = false;

        $roles_available_str = serialize($security['roles_available']);
        foreach($roles as $role) {
            $role_available = strpos($roles_available_str, '"'.$role.'"');
            if ($role_available != false) {
                $role_available = true;
                break;
            }
        }

        if ($role_available) {
            foreach($access as $a) {
                if (isset($target[$a])) {
                    $pre_target = $target;
                    $target = $target[$a];
                } else {
                    $target_found = false;
                    break;
                }
            }

            if ($target_found) {
                $target_str = serialize($target);

                if ($any and isset($pre_target['any']) ) {
                    $target_str.= serialize($pre_target['any']);
                }

               /* preg_match_all('/ROLE_\w+/', $target_str, $target_arr);
                if (isset($target_arr[0])) {
                    $target_arr = $target_arr[0];
                    $target_str = serialize($target_arr);
                } else {
                    $target_str = "";
                }
                */

                foreach($roles as $role) {
                    $granted = strpos($target_str, '"'.$role.'"');
                    if ($granted != false) {
                        $granted = true;
                        break;
                    }
                }
            }
        }
        return $granted;
    }

    public function aspectRatio($width, $height, $str = null) {
        $aspect = ($width>$height)?$width/$height:$height/$width;
        if ($aspect != (int)$aspect) {
            $aspect = number_format($aspect, 2);
        }
        if ($str) {
            return ($width>$height)?$aspect.':1':'1:'.$aspect;
        }
        return $aspect;
    }

    /**
     * Media asset
     */
    public function mediaAsset($folder, $filename) {
        return $this->container->get('assets.packages')->getUrl($this->container->get("app.uploader")->imageFilename($folder, $filename));
    }

    /**
     * Avatar asset
     */
    public function avatarAsset($filename) {
        return $this->mediaAsset($this->parameters['media']['avatar'], $filename);
    }

    /**
     * Get route
     */
    public function getRoute()
    {
        if(null !== $this->request)
        {
            return $this->request->getCurrentRequest()->get("_route");
        }
        return null;
    }

    /**
     * Get route root
     */
    public function getRouteRoot()
    {
        if(null !== $this->request)
        {
            return explode("_", $this->request->getCurrentRequest()->get("_route"))[0];
        }
        return null;
    }

    public function isRoute($s) {
        return ($s == $this->getRoute());
    }

    public function isRouteRoot($s) {
        return ($s == $this->getRouteRoot());
    }

    /**
     * Get if graphic notifications
     */
    public function isGraphicNotifications($user)
    {
            return true;
    }

    /**
     * Get if sound notifications
     */
    public function isSoundNotifications($user)
    {
       return true;

    }

    /**
     * Get if light theme
     */
    public function isLightTheme($user)
    {
        return false;
    }

    /**
     * Get get theme
     */
    public function getTheme($user)
    {
        return 'blue';
    }

    /**
     * Get is current theme
     */
    public function isCurrentTheme($user, $theme)
    {
         return false;
    }

    public function getName()
    {
        return 'app_extension';
    }
}
