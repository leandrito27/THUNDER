<?php
class asistenciaControllers
{
    private $modelo;

    public function __construct($modelo)
    {
        $this->modelo = $modelo;
    }
    public function registrarCsv($csv)
    {
        $contenidoCSV = $this->modelo->registrarCsv($csv);
        $asistenciaProcesada=$this->modelo->registrarAsistencia($contenidoCSV);
        $resultado = array('mensaje' => $asistenciaProcesada);
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    }

    public function reporteHome($tipo, $fecha)
    {
        if ($tipo == "panel") {
            $panelHome = $this->modelo->HomePanelInformativo($fecha);
            $reporteSemana = $this->modelo->HomeReporteSemanal($fecha);
            $reporteMensual = $this->modelo->HomeReporteMensual($fecha);
            $reporteAnual = $this->modelo->HomeReporteAnual($fecha);
            $reporteDiario = $this->modelo->HomeReporteDiarioIngreso($fecha);
            $reporteDiarioS = $this->modelo->HomeReporteDiarioSalida($fecha);
            $paqueteResultados = array(
                'panel' => $panelHome, 
                'semana' => $reporteSemana, 
                'mensual' => $reporteMensual, 
                'anual' => $reporteAnual, 
                'diario' => $reporteDiario, 
                'salida' => $reporteDiarioS,
            );
            echo json_encode($paqueteResultados, JSON_UNESCAPED_UNICODE);
        }
    }
}
