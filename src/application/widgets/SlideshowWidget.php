<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 06/08/14
 * Time: 15:44
 */


class SlideshowWidget extends AbstractWidget {

    public function __construct()
    {
        parent::__construct('Slideshow','Display a chosen slideshow');
    }

    public function form($settings)
    {
        $slideshows = SlideshowQuery::create()->find();
        $form = '<label>Slideshow to show</label><select name="slideshow" autocomplete="off">';
        foreach ($slideshows as $slideshow) {
            $form .= '<option value="' . $slideshow->getId() . '"' . (isset($settings['slideshow'])? ($settings['slideshow'] == $slideshow->getId() ? 'selected="selected"' : '') : '') . '>' . $slideshow->getName() . '</option>';
        }
        $form .= '</select>
        <label>Background Colour</label>
        <input type="text" name="background" value="'. (isset($settings['background']) ? $settings['background'] : '') .'">';
        return $form;
    }


    public function view($settings, Screen $screen)
    {
        $view = '<div class="slideshow">';
        $slideshow = SlideshowQuery::create()->findOneById($settings['slideshow']);
        $background = (isset($settings['background']) ? $settings['background'] : '#2b0014');
        foreach ($slideshow->getImages() as $img) {
            $view .= '<img src="' . $img->getSizeUrl($slideshow->getWidth(),$slideshow->getHeight(), $background) . '">';
        }
        $view .= '</div>';

        return $view;
    }

    public function scripts()
    {
        return array('jquery.cycle2.min.js', 'slideshow.js');
    }

}