<?php
$conexion = false;
$conexion=mysqli_connect("localhost","root","","bd_trasciende");
    if (!$conexion) {
        $conexion = mysqli_connect("localhost", "root", "", "bd_trasciende");
    }
    //poder manipular acentos y la ñ
    if ($conexion) {
        $conexion->set_charset("utf8");
    }

    if ($conexion && isset($_POST["nombre"]) && isset($_POST["contraseña"])) {

        if($_POST["nombre"] != "" && $_POST["contraseña"] != ""){
            $usuario  = $_POST["nombre"];
            $contraseña = $_POST["contraseña"];

        $consulta="SELECT *
                        FROM tb_usuarios 
                        WHERE usuario='".$usuario."'";
            $log=mysqli_query($conexion,$consulta);
        if($log->num_rows >0){
            while($row=mysqli_fetch_array($log)){
                if (password_verify($contraseña,$row["contrasena"])) {
                @session_start();
                $_SESSION["id_user"]           = $row["id"];
                $_SESSION["user"]         = $row["usuario"];
                // ADMINISTRADOR
                    echo "<script type=\"text/javascript\">
                    alert(\"Bienvenido al sistema\"); 
                    </script>";
                    echo "<script type=\"text/javascript\">
                    window.location='../../pages/vistaClientes.php';
                    </script>";
            }else{
                echo "<script type=\"text/javascript\">
                alert(\"Usuario o contraseña incorrecta\"); 
                </script>";
                echo "<script type=\"text/javascript\">
                    window.location='../../pages/inicio-sesion.html';
                    </script>";
            }
            }                 
        } else{
            echo "<script type=\"text/javascript\">
                alert(\"Usuario o contraseña incorrecta\"); 
                </script>";
            echo "<script type=\"text/javascript\">
                    window.location='../../pages/inicio-sesion.html';
                    </script>";
        }
        }else{

            echo "<script type=\"text/javascript\">
            alert(\"Rellena el formulario\"); 
            </script>";
        }
    } else {
        // Mostrar mensaje de error si no se puede establecer la conexión
        echo "No se pudo establecer conexión con la base de datos";
    }
?>