<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Load_module
{
	private $ci;

    function __construct()
    {
        $this->ci =& get_instance();
    }

    /*
    * Digunakan untuk menampilkan menu-menu back-end admin
    */
    function menuBackEnd()
    {
        $menu = array();

        $sql = 'SELECT
                        *
                    FROM
                        `lumi_pages`';

        $query = $this->ci->db->query($sql);
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $menu[$row->page_id]['id']		    = $row->page_id;
                $menu[$row->page_id]['title']       = $row->page_title;
                $menu[$row->page_id]['url']         = $row->page_url;
                $menu[$row->page_id]['parent']      = $row->parent_id;
                $menu[$row->page_id]['is_parent']   = $row->is_parent;
                $menu[$row->page_id]['show']        = $row->show_menu;
                $menu[$row->page_id]['back_end']    = $row->back_end;
            }
        }
        $query->free_result();

        $html  = "";

        for ($i = 1; $i <= count($menu); $i++)
        {
            if (is_array($menu[$i]))
            {
                if ($menu[$i]['show'] && $menu[$i]['parent'] == 0)
                {
                    if ($menu[$i]['is_parent'] == TRUE)
                    {
                        if($this->ci->session->userdata('level') != 'A' && $menu[$i]['back_end'] == FALSE)
                        {
                            $html .= '<li style="display:none">
                                        <a href="#">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="nav nav-second-level">';
                        }else
                        {
                            $html .= '<li>
                                        <a href="#">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="nav nav-second-level">';
                        }
                    }
                    else
                    {
                        if($this->ci->session->userdata('level') != 'A' && $menu[$i]['back_end'] == FALSE)
                        {
                            $html .= '<li style="display:none">
                                        <a href="'. base_url().'admin/'.$menu[$i]['url'].'">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                        </a>';
                        }else
                        {
                            $html .= '<li>
                                        <a href="'. base_url().'admin/'.$menu[$i]['url'].'">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                        </a>';
                        }
                    }
                    $html .= $this->getChildsBackEnd($menu, $i);
                    $html .= '</li>';
                }
            }
            else
            {
                exit (sprintf('menu nr %s harus dalam bentuk array', $i));
            }
        }
        $html .= '';
        return $html;
    }

    function getChildsBackEnd($menu, $parent_id)
    {
        $has_subcats = FALSE;
        $html  = '';
        for ($i = 1; $i <= count($menu); $i++)
        {
            if ($menu[$i]['show'] && $menu[$i]['parent'] == $parent_id)
            {
                $has_subcats = TRUE;
                if ($menu[$i]['is_parent'] == TRUE)
                {
                    $html .= '<li> '.$menu[$i]['title'].'';
                }
                else
                {
                    $html .= '<li>
                                <a href="'. base_url().'admin/'.$menu[$i]['url'].'"> '.$menu[$i]['title'].'</a>';
                }
                $html .= $this->getChildsBackEnd($menu, $i);
                $html .= '</li>';
            }
        }
        $html .= '</ul></li>';
        return ($has_subcats) ? $html : FALSE;
    }

    /*
    * Digunakan untuk menampilkan menu-menu front-end
    */
    function menuFrontEnd()
    {
        $menu = array();

        $sql = 'SELECT
                        *
                    FROM
                        `lumi_pages`';

        $query = $this->ci->db->query($sql);
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $menu[$row->page_id]['id']          = $row->page_id;
                $menu[$row->page_id]['title']       = $row->page_title;
                $menu[$row->page_id]['url']         = $row->page_url;
                $menu[$row->page_id]['parent']      = $row->parent_id;
                $menu[$row->page_id]['is_parent']   = $row->is_parent;
                $menu[$row->page_id]['show']        = $row->show_menu;
                $menu[$row->page_id]['front_end']   = $row->front_end;
            }
        }
        $query->free_result();

        $html  = "";

        for ($i = 1; $i <= count($menu); $i++)
        {
            if (is_array($menu[$i]))
            {
                if ($menu[$i]['show'] && $menu[$i]['parent'] == 0)
                {
                    if ($menu[$i]['is_parent'] == TRUE)
                    {
                        if($menu[$i]['front_end'] == FALSE)
                        {
                            $html .= '<li class="dropdown" style="display:none">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$menu[$i]['title'].' 
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">';
                        }else
                        {
                            $html .= '<li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$menu[$i]['title'].' 
                                            <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">';
                        }
                    }
                    else
                    {
                        if($menu[$i]['front_end'] == FALSE)
                        {
                            $html .= '<li style="display:none">
                                        <a href="'. base_url().''.$menu[$i]['url'].'">'.$menu[$i]['title'].'</a>';
                        }else
                        {
                            $html .= '<li>
                                        <a href="'. base_url().''.$menu[$i]['url'].'">'.$menu[$i]['title'].'</a>';
                        }
                    }
                    $html .= $this->getChildsFrontEnd($menu, $i);
                    $html .= '</li>';
                }
            }
            else
            {
                exit (sprintf('menu nr %s harus dalam bentuk array', $i));
            }
        }
        $html .= '';
        return $html;
    }

    function getChildsFrontEnd($menu, $parent_id)
    {
        $has_subcats = FALSE;
        $html  = '';
        for ($i = 1; $i <= count($menu); $i++)
        {
            if ($menu[$i]['show'] && $menu[$i]['parent'] == $parent_id)
            {
                $has_subcats = TRUE;
                if ($menu[$i]['is_parent'] == TRUE)
                {
                    $html .= '<li> '.$menu[$i]['title'].'';
                }
                else
                {
                    $html .= '<li>
                                <a href="'. base_url().''.$menu[$i]['url'].'"> '.$menu[$i]['title'].'</a>';
                }
                $html .= $this->getChildsFrontEnd($menu, $i);
                $html .= '</li>';
            }
        }
        $html .= '</ul></li>';
        return ($has_subcats) ? $html : FALSE;
    }

    /*
    * Digunakan untuk menampilkan menu-menu back-end contributor
    */
    function menuBackEndCo()
    {
        $menu = array();

        $sql = 'SELECT
                        *
                    FROM
                        `lumi_pages`';

        $query = $this->ci->db->query($sql);
        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $menu[$row->page_id]['id']          = $row->page_id;
                $menu[$row->page_id]['title']       = $row->page_title;
                $menu[$row->page_id]['url']         = $row->page_url;
                $menu[$row->page_id]['parent']      = $row->parent_id;
                $menu[$row->page_id]['is_parent']   = $row->is_parent;
                $menu[$row->page_id]['show']        = $row->show_menu;
                $menu[$row->page_id]['back_end']         = $row->back_end;
            }
        }
        $query->free_result();

        $html  = "";

        for ($i = 1; $i <= count($menu); $i++)
        {
            if (is_array($menu[$i]))
            {
                if ($menu[$i]['show'] && $menu[$i]['parent'] == 0)
                {
                    if ($menu[$i]['is_parent'] == TRUE)
                    {
                        if($this->ci->session->userdata('level') != 'A' && $menu[$i]['back_end'] == FALSE)
                        {
                            $html .= '<li style="display:none">
                                        <a href="#">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="nav nav-second-level">';
                        }else
                        {
                            $html .= '<li>
                                        <a href="#">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="nav nav-second-level">';
                        }
                    }
                    else
                    {
                        if($this->ci->session->userdata('level') != 'A' && $menu[$i]['back_end'] == FALSE)
                        {
                            $html .= '<li style="display:none">
                                        <a href="'. base_url().'contributor/'.$menu[$i]['url'].'">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                        </a>';
                        }else
                        {
                            $html .= '<li>
                                        <a href="'. base_url().'contributor/'.$menu[$i]['url'].'">
                                            <i class="fa fa-gear fa-fw"></i> '.$menu[$i]['title'].'
                                        </a>';
                        }
                    }
                    $html .= $this->getChildsBackEndCo($menu, $i);
                    $html .= '</li>';
                }
            }
            else
            {
                exit (sprintf('menu nr %s harus dalam bentuk array', $i));
            }
        }
        $html .= '';
        return $html;
    }

    function getChildsBackEndCo($menu, $parent_id)
    {
        $has_subcats = FALSE;
        $html  = '';
        for ($i = 1; $i <= count($menu); $i++)
        {
            if ($menu[$i]['show'] && $menu[$i]['parent'] == $parent_id)
            {
                $has_subcats = TRUE;
                if ($menu[$i]['is_parent'] == TRUE)
                {
                    $html .= '<li> '.$menu[$i]['title'].'';
                }
                else
                {
                    $html .= '<li>
                                <a href="'. base_url().'contributor/'.$menu[$i]['url'].'"> '.$menu[$i]['title'].'</a>';
                }
                $html .= $this->getChildsBackEndCo($menu, $i);
                $html .= '</li>';
            }
        }
        $html .= '</ul></li>';
        return ($has_subcats) ? $html : FALSE;
    }
}