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

        $orderBy = false;
        if (isset($req->query->orderBy)) {
            $orderBy = $req->query->orderBy;
        }

        $sedes = $this->modelo->obtenerSedes($orderBy);
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
