<?php
class modeloSede
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=voluntariado;charset=utf8', 'root', '');
    }

    public function obtenerSedes($orderBy = false, $offset = 0, $limit = 0)
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
            }
        }

        if ($limit > 0)
            $sql .= ' LIMIT :limit OFFSET :offset';

        $query = $this->db->prepare($sql);
        if ($limit > 0) {
            $query->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        }
        $query->execute();
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
