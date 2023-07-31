<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Obtener los valores del formulario
	$nombre 	= $_POST['nombre'] ?? '';
	$email 		= $_POST['email'] ?? '';
	$address 	= 	$_POST['address'] ?? '';
	$pais 		=	$_POST['pais'] ?? '';

	// Validar si se enviaron los valores
	if (!empty($nombre) && !empty($email) && !empty($address) && !empty($pais)) {
		// Ruta y nombre del archivo
		$ruta_archivo = "./baseDatos.txt";

		// Verificar si el archivo existe
		$archivo_existe = file_exists($ruta_archivo);

		// Obtener el número de registros actuales o inicializar en 0 si el archivo no existe
		$num_registros = 0;
		if ($archivo_existe) {
			$lineas = file($ruta_archivo, FILE_SKIP_EMPTY_LINES);
			foreach ($lineas as $linea) {
				if (preg_match('/^\d+\./', $linea)) {
					$num_registros++;
				}
			}
		}

		// Incrementar el número de registros para el nuevo registro
		$num_registros++;

		// Abrir el archivo en modo de escritura
		$file = fopen($ruta_archivo, "a");
		if ($file) {
			// Escribir la cabecera si el archivo no existe
			if (!$archivo_existe) {
				fwrite($file, "Id \tNombre Persona \t\tEmail Persona \t\t\tDirección \t\tPais" . PHP_EOL);
				fwrite($file, "=========================================================================" . PHP_EOL);
			}

			// Escribir el nuevo registro en el archivo con el formato requerido
			fwrite($file, "$num_registros.\t$nombre\t\t\t$email\t\t\t$address\t\t$pais" . PHP_EOL);
			fwrite($file, " -------------------------------------------------------------------------" . PHP_EOL);

			// Cerrar el archivo
			fclose($file);

			// Redirigir a una página específica
			header('Location: index.html');
			exit();
		} else {
			echo "Error al abrir el archivo.";
		}
	} else {
		echo "Por favor, completa todos los campos del formulario.";
	}
} else {
	echo "Acceso inválido.";
}
