<?php
include('../../controllers/conexion_prueba.php');

if (isset($_POST['query'])) {
    $q = $_POST['query'];

    $sql = "SELECT id_proveedor, proveedor FROM proveedores WHERE proveedor LIKE ? LIMIT 5";
    if ($stmt = $con->prepare($sql)) {
        $like = "%{$q}%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        $stmt->bind_result($id_proveedor, $proveedor);

        // Escapamos la consulta para usarla como regex
        $highlight = preg_quote($q, '/');

        $found = false;
        while ($stmt->fetch()) {
            $found = true;
            // Resaltar coincidencia en negritas
            $proveedorResaltado = preg_replace(
                "/($highlight)/i",
                '<strong style="color:#007bff;">$1</strong>',
                htmlspecialchars($proveedor, ENT_QUOTES, 'UTF-8')
            );

            echo '<a href="#" 
                     class="list-group-item list-group-item-action item-proveedor" 
                     data-id="' . htmlspecialchars($id_proveedor, ENT_QUOTES, 'UTF-8') . '">'
                 . $proveedorResaltado .
                 '</a>';
        }

        if (!$found) {
            echo '<div class="list-group-item text-muted text-center">Sin resultados</div>';
        }

        $stmt->close();
    }
}
?>
