# TPE-tercer-entrega
aplicamos el codigo a la tabla sede

-- listar todas las sedes  (GET)
{base url}/sede

-- litsta las sedes ordenados ascendente por cualquier campo de la tabla  (GET)
{base url}/sede?orderBy=pais

-- paginar (GET)
{base url}sede?page=2&size=1

-- modificar un registro (PUT)
{base url}/sede/id

-- insertar un registro (POST)
{base url}/sede

