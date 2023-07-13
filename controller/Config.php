<?php

class Config
{
    public function __construct()
    {

    }
    public $config;
    public function get()
    {
        $avatar = '';
        if (isset($_SESSION['node']['uid']) && !empty($_SESSION['node']['uid'])) {
            $id = ($_SESSION['node']['uid']);


            $avatar = (new Orm('usuario'))
                ->select('usuario_avatar as avatar')
                ->find($id);


            if (empty($avatar)) {
                $avatar = 'nopic.png';
            } else {
                $avatar = $avatar->avatar;
            }
        }
        $conf = (new Orm('config'))->get()[0];
        if (Session::node('uid') != null) {
            $conf->uname = ucfirst(Session::node('unome'));
            $conf->level = ucfirst(Session::node('ulevel'));
            $conf->id = ucfirst(Session::node('uid'));
        }
        $conf->baseUri = Http::base();
        $conf->isMobile = $this->isMobile();
        $conf->avatar = $avatar;
        $conf->whatsNum = Filter::phone2Number($conf->config_site_telefone2);
        $conf->widthLogo = intval($conf->config_site_logo_formato) == 1 ? '100' : '300';

        // formatação de telefone
        $conf->config_site_telefone2_clean = Filter::phone2Number($conf->config_site_telefone2);
        $conf->config_site_telefone_clean = Filter::phone2Number($conf->config_site_telefone);
        $conf->config_site_tel_admin_clean = Filter::phone2Number($conf->config_site_tel_admin);
        $conf->config_site_whats_admin_clean = Filter::phone2Number($conf->config_site_whats_admin);

        $temas = [
            'quarzar',
        ];
        $conf->config_tema_path = $temas[intval($conf->config_tema_id) - 1];
        $conf->config_maps_embed_query = null;
        if(!empty($conf->config_site_cep) && !empty($conf->config_site_rua) && !empty($conf->config_site_num) && !empty($conf->config_site_bairro) && !empty($conf->config_site_cidade) && !empty($conf->config_site_uf)) {
            $rua = str_replace(" ", "+", $conf->config_site_rua);
            $num = str_replace(" ", "+", $conf->config_site_num);
            $bairro = str_replace(" ", "+", $conf->config_site_bairro);
            $cidade = str_replace(" ", "+", $conf->config_site_cidade);
            $conf->config_maps_embed_query = "$rua,+$num+,+$bairro+,+$cidade+-+$conf->config_site_uf,+$conf->config_site_cep,Brasil";
        }
        return $conf;
    }
    public function getSmtp()
    {
        return (new Orm('smtp'))->select('smtp_id, smtp_host,smtp_email,smtp_port,smtp_secure,smtp_nome')->get()[0];
    }
    public function get_rede_social()
    {
        return (new Orm('rede_social'))->get()[0];
    }


    public function isMobile() {
        $is_mobile = false;

        //Se tiver em branco, não é mobile
        if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
            $is_mobile = false;

        //Senão, se encontrar alguma das expressões abaixo, será mobile
        } elseif ( strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false ) {
                $is_mobile = true;

        //Senão encontrar nada, não será mobile
        } else {
            $is_mobile = false;
        }

        return $is_mobile;
    }
}
