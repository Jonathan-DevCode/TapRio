<?php

class AppTools
{
    public static function verifyToken() {
        $token = Req::post('token');
        if(empty($token)) {
            AppTools::sendUnauthorized();
        }

        return AppTools::getUserByToken($token);
    }

    public static function getUserByToken($token = null) {
        $user = (new Orm('usuario'))
            ->where("usuario_token_app = '{$token}'")
            ->get();
        if(!isset($user[0])) {
            AppTools::sendUnauthorized();
        }

        return $user[0];
    }

    public static function listaCaracteristicasVinculadas($imovel_id = 0)
    {
        $ids = [];
        $caracteristicas = (new Orm('imovel_caracteristica'))
            ->where("imovel_caracteristica_imovel_id = '{$imovel_id}'")
            ->get();

        if (isset($caracteristicas[0])) {
            foreach ($caracteristicas as $c) {
                $ids[] = $c->imovel_caracteristica_caracteristica_id;
            }
        }

        return $ids;
    }

    public static function listaComCaracteristicas($tipo_caracteristica = "ambos")
    {
        $categorias = (new Orm('caracteristica_categoria'))->get();

        $categorias_retorno = [];

        if (isset($categorias[0])) {
            foreach ($categorias as $cat) {
                $caracteristicas = (new Orm("caracteristica"))
                    ->where("(caracteristica_tipo = 'ambos' OR caracteristica_tipo = '{$tipo_caracteristica}') AND caracteristica_categoria_id = '" . intval($cat->caracteristica_categoria_id) . "'")
                    ->order("caracteristica_diferencial DESC, caracteristica_nome")
                    ->get();

                if (isset($caracteristicas[0])) {
                    $cat->caracteristicas = $caracteristicas;
                    $categorias_retorno[] = $cat;
                }
            }
        }

        return $categorias_retorno;
    }

    public static function atualiza_informacoes_dinamicas($imovel_id)
    {
        $imovel = (new Orm('imovel'))->find($imovel_id);
        if (!isset($imovel->imovel_id)) {
            return false;
        }

        $codigo_imovel = "T";
        $titulo_imovel = "";
        if (isset($imovel->imovel_categoria) && !empty($imovel->imovel_categoria)) {
            $categoria = (new Orm("categoria_imovel"))->find($imovel->imovel_categoria);
            if (isset($categoria->categoria_imovel_id)) {
                $codigo_imovel .= $categoria->categoria_imovel_code;
                $titulo_imovel .= $categoria->categoria_imovel_nome . " com ";
            }
        }
        $titulo_imovel .= $imovel->imovel_quartos;
        if ($imovel->imovel_quartos <= 1) {
            $titulo_imovel .= " Quarto";
        } else {
            $titulo_imovel .= " Quartos";
        }

        $codigo_imovel .= $imovel->imovel_quartos;
        $codigo_imovel .= $imovel->imovel_vagas;
        if ($imovel->imovel_tipo_negociacao == "venda" || $imovel->imovel_tipo_negociacao == "venda_aluguel") {
            $codigo_imovel .= "V";
            $titulo_imovel .= " à venda";
        } else {
            $codigo_imovel .= "A";
            $titulo_imovel .= " para aluguel";
        }

        $titulo_imovel .= ", " . $imovel->imovel_area_util . "m²";

        if ($imovel->imovel_bairro_view == 1) {
            $bairro = (new Orm("bairro"))->find($imovel->imovel_bairro_id);
            if (isset($bairro->bairro_id)) {
                $titulo_imovel .= " - " . $bairro->bairro_titulo;
            }
        }

        if ($imovel->imovel_uf_view == 1) {
            $uf = (new Orm("uf"))->find($imovel->imovel_uf_id);
            if (isset($uf->uf_id)) {
                $titulo_imovel .= " - " . $uf->uf_sigla;
            }
        }

        if ($imovel_id < 10) {
            $codigo_imovel .= "000" . $imovel_id;
        } else if ($imovel_id < 100) {
            $codigo_imovel .= "00" . $imovel_id;
        } else if ($imovel_id < 1000) {
            $codigo_imovel .= "0" . $imovel_id;
        } else {
            $codigo_imovel .=  $imovel_id;
        }

        $corretor = (new Orm('usuario'))->find($imovel->imovel_user_id);
        if (isset($corretor->usuario_id)) {
            $codigo_imovel .=  $corretor->usuario_code;
        }

        $with = [
            "id" => $imovel_id,
            'titulo' => $titulo_imovel,
            "ref" => strtoupper($codigo_imovel)
        ];
        (new Orm('imovel'))->with($with)->save();
    }

    // response

    public static function errorResponse($msg = "Não foi possível processar a solicitação") {
        echo json_encode(['status' => 400, 'msg' => $msg]);
        exit;
    }

    public static function sendUnauthorized() {
        echo json_encode(['status' => 401]);
        exit;
    }

    public static function successResponse($msg = "Sucesso", $data = []) {
        echo json_encode(['status' => 200, 'msg' => $msg, 'data' => $data]);
        exit;
    }
}
