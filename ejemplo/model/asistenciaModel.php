<?php
 
class asistenciaModel
{
    private $conexion;
    public function __construct()
    {
    }
    public function ordenarIdFechaHora($a, $b)
    { 
        if ($a['ide'] != $b['ide']) {
            return $a['ide'] - $b['ide'];
        } 
        $fechaA = strtotime($a['fecha']);
        $fechaB = strtotime($b['fecha']);
        if ($fechaA != $fechaB) {
            return $fechaA - $fechaB;
        } 
        $horaA = strtotime($a['hora']);
        $horaB = strtotime($b['hora']);
        return $horaA - $horaB;
    }
    public function registrarCsv($csv)
    {
        $resultados = array();
        $leerCSV = fopen($csv, "r");
        $encabezado = true;
        while (($data = fgetcsv($leerCSV, 1000, ";")) !== FALSE) {
            if ($encabezado) {
                $encabezado = false;
                continue;
            }
            list($fecha, $hora) = explode(" ", $data[0]);
            list($dia, $mes, $anio) = explode("/", $fecha);
            $fila = array(
                'ide' => $data[5],
                'dni' => $data[2],
                'fecha' => $anio . '/' . $mes . '/' . $dia,
                'nrc' => $data[6],
                'marcacion' => $data[7],
                'hora' => $hora,
                'jornada' => $data[3],
            );
            $resultados[] = $fila;
        }
        fclose($leerCSV);
        usort($resultados, array($this,  'ordenarIdFechaHora'));

        $jsonResultados = $resultados;
        return $jsonResultados;
    }

    public function registrarAsistencia($registro)
    {
        $conexion = conectar();
      
        $mensaje = array();
        $instructor = null;
        $fechaAsistencia = null;
        /*  if ($stmt) { */
        foreach ($registro as $resul) {
            if ($instructor != $resul['ide']) {
                $instructor = $resul['ide'];
                $fechaAsistencia = $resul['fecha'];

                $sqlHorario = "CALL AsistenciaHorario(?,?)";
                $stmtHorario = mysqli_prepare($conexion, $sqlHorario);
                mysqli_stmt_bind_param($stmtHorario, "is", $instructor, $fechaAsistencia);
                mysqli_stmt_execute($stmtHorario);
                mysqli_stmt_bind_result($stmtHorario, $Hid, $fecha_i_, $fecha_f_, $dia_, $inicio_, $fin_);
                while (mysqli_stmt_fetch($stmtHorario)) {
                    $r = array('HoarioID' => $Hid, 'Fecha_I' => $fecha_i_, 'Fecha_F' => $fecha_f_, 'Dia' => $dia_, 'De' => $inicio_, 'Hasta' => $fin_);
                    $mensaje[] = $r;
                }
                mysqli_stmt_close($stmtHorario);
            }
            
        }
        

        return $mensaje;
    }
}
