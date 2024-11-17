<?php

require_once './app/modelos/modeloSede.php';
require_once './app/vistas/vistaJSON.php';

class apiControlador
{
    private $modelo;
    private $vista;

    public function __construct()
    {
        $this->modelo = new modeloSede();
        $this->vista = new vistaJSON();
    }

    public function obtenerTodas($req, $res)
    {
        $page = 0;
        $size = 0;
        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }

        if (isset($req->query->page))
            $page = max(1, $req->query->page);

        if (isset($req->query->size))
            $size = max(1, $req->query->size);

        $offset = ($page - 1) * $size;
        $sedes = $this->modelo->obtenerSedes($orderBy, $offset, $size);
        return $this->vista->response($sedes);
    }

    public function actualizar($req, $res)
    {
        $id = $req->params->id;
        $sede = $this->modelo->obtenerSedePorId($id);
        if (!$sede) {
            return $this->vista->response("la tarea con el id= $id no existe", 404);
        }

        if (empty($req->body->pais) || empty($req->body->ciudad)) {
            return $this->vista->response('Faltan completar datos', 400);
        }

        $pais = $req->body->pais;
        $ciudad = $req->body->ciudad;
        $this->modelo->editarSede($id, $pais, $ciudad);
        $sede = $this->modelo->obtenerSedePorId($id);
        return $this->vista->response($sede, 200);
    }
}
