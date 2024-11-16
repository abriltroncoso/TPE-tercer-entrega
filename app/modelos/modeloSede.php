<?php
class modeloSede
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=voluntariado;charset=utf8', 'root', '');
    }

    public function obtenerSedes($orderBy = false)
    {
        $sql = 'SELECT * FROM sede';
        if ($orderBy) {
            switch ($orderBy) {
                case 'pais':
                    $sql .= ' ORDER BY pais';
                    break;
                case 'ciudad':
                    $sql .= ' ORDER BY ciudad';
                    break;
                default:

                    break;
            }
        }
        $query = $this->db->prepare($sql);
        $query->execute();

        // 3. Obtengo los datos en un arreglo de objetos
        $sedes = $query->fetchAll(PDO::FETCH_OBJ);

        return $sedes;
    }

    public function obtenerSedePorId($id_sede)
    {
        $query = $this->db->prepare('SELECT * FROM sede WHERE id_sede = ?');
        $query->execute([$id_sede]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function contarVoluntariosPorSede($id_sede)
    {
        $query = $this->db->prepare('SELECT COUNT(*) AS total FROM voluntario WHERE id_sede = ?');
        $query->execute([$id_sede]);
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result->total;
    }

    public function agregarSede($pais, $ciudad)
    {
        $query = $this->db->prepare('INSERT INTO sede (pais, ciudad) VALUES (?, ?)');
        $query->execute([$pais, $ciudad]);
    }

    public function editarSede($id_sede, $pais, $ciudad)
    {
        $query = $this->db->prepare('UPDATE sede SET pais = ?, ciudad = ? WHERE id_sede = ?');
        $query->execute([$pais, $ciudad, $id_sede]);
    }
}