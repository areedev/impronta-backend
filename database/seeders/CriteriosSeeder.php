<?php

namespace Database\Seeders;

use App\Models\Competencia;
use App\Models\CriterioDesempeñoInterno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriteriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = array(
            array("competencia" => "IMP034", "llave" => "CDIMP001", "criterio" => "Conoce el manual del vehículo."),
            array("competencia" => "IMP035", "llave" => "CDIMP002", "criterio" => "Conoce y ha sido instruido sobre el plan y reglamento de transito."),
            array("competencia" => "CC005", "llave" => "CDIMP003", "criterio" => "Realiza su control de salud y estado físico documentándolo. Conoce las señales personales sobre somnolencia, además de los protocolos asociados que aplican en la faena."),
            array("competencia" => "IMP036", "llave" => "CDIMP004", "criterio" => "Participa en las charla de seguridad en forma positiva."),
            array("competencia" => "IMP037", "llave" => "CDIMP005", "criterio" => "Mantiene en su poder la tarjeta verde"),
            array("competencia" => "IMP038", "llave" => "CDIMP006", "criterio" => "Realiza el análisis de riesgo del trabajo asignado."),
            array("competencia" => "IMP039", "llave" => "CDIMP007", "criterio" => "El equipo de protección personal (EPP) es revisado y utilizado correctamente. Es el adecuado para la tarea asignada."),
            array("competencia" => "IMP040", "llave" => "CDIMP008", "criterio" => "Revisa la pauta de trabajo del día. Aclara dudas que se le presentan con su líder o supervisor."),
            array("competencia" => "CC043", "llave" => "CDIMP009", "criterio" => "Realizar inspección preoperacional del vehículo/equipo, evaluando cada uno de los componentes o sistemas definidos en la lista de chequeo, dejando el registro respectivo."),
            array("competencia" => "CC043", "llave" => "CDIMP010", "criterio" => "Verifica que el vehículo cuenta con los accesorios de seguridad y la documentación del vehículo se encuentra en orden."),
            array("competencia" => "CC016", "llave" => "CDIMP011", "criterio" => "La carga de combustible del vehículo es realizada de acuerdo a procedimiento."),
            array("competencia" => "CC002", "llave" => "CDIMP012", "criterio" => "Conoce y verifica que el equipo/vehículo cumpla con la capacidad de carga de acuerdo a recomendaciones del fabricante, normativa y legislación vigente"),
            array("competencia" => "CC036", "llave" => "CDIMP013", "criterio" => "Utiliza radio de comunicaciones para gestionar permisos para ingresar a áreas o alertar de condiciones peligrosas en la ruta."),
            array("competencia" => "CC003", "llave" => "CDIMP014", "criterio" => "Coordina y cumple correctamente la función de escolta según procedimiento de trabajo."),
            array("competencia" => "CC059", "llave" => "CDIMP015", "criterio" => "Revisa y documenta los extintores del vehículo."),
            array("competencia" => "CC059", "llave" => "CDIMP016", "criterio" => "Ha sido instruido en el uso de extintores."),
            array("competencia" => "CC059", "llave" => "CDIMP017", "criterio" => "Conoce el procedimiento de emergencia en caso de incendio del vehículo."),
            array("competencia" => "IMP038", "llave" => "CDIMP018", "criterio" => "Identifica y controla los riesgos potenciales y peligros presentes en caminos industriales de faena minera de acuerdo  a técnicas de conducción aplicadas en faenas mineras, condiciones climatológicas, procedimientos de trabajo."),
            array("competencia" => "IMP043", "llave" => "CDIMP019", "criterio" => "Mantiene distancia adecuada con otros vehículos de acuerdo a técnicas de conducción aplicadas en faenas mineras, condiciones climatológicas , procedimientos de trabajo."),
            array("competencia" => "CC007", "llave" => "CDIMP020", "criterio" => "Estaciona correctamente el vehículo en lugares habilitados quedando la cabina desocupada, retirando las llaves, usando cuñas, direccionando ruedas, aplicando freno de mano, enganchando o parqueado."),
            array("competencia" => "CC004", "llave" => "CDIMP021", "criterio" => "Conduce respetando los límites de velocidad establecidos de acuerdo a la normativa vigente y las condiciones del entorno. Especificando el elemento distancia de frenado"),
            array("competencia" => "CC018", "llave" => "CDIMP022", "criterio" => "Utiliza correctamente los frenos durante la conducción y/o operación del equipo/vehículo de acuerdo con las técnicas recomendadas y procedimientos de trabajo."),
            array("competencia" => "CC007", "llave" => "CDIMP023", "criterio" => "Conoce y aplica detenciones (por ejemplo para mantención o estacionamiento) de manera segura, parqueo efectivo, de acuerdo a las condiciones del terreno y del entorno, condiciones operacionales de la mina, reglamento interno de tránsito, procedimiento de trabajo y normativa vigente."),
            array("competencia" => "CC008", "llave" => "CDIMP024", "criterio" => "Aplica técnicas de conducción defensiva observando todo lo que sucede en el entorno, de modo de anticiparse a situaciones de peligro y evitar cualquier tipo de riesgo."),
            array("competencia" => "CC001", "llave" => "CDIMP025", "criterio" => "Señaliza y aplica técnicas de conducción en pendiente ascendente y descendente.  Especificar sobre tecnicas de control y frenado del equipo."),
            array("competencia" => "CC043", "llave" => "CDIMP026", "criterio" => "Conoce y aplica la verificación del sistema check point de los neumáticos."),
            array("competencia" => "CC045", "llave" => "CDIMP027", "criterio" => "Utiliza cinturon de seguridad de acuerdo a procedimiento tanto conductor como pasajeros."),
            array("competencia" => "CC021", "llave" => "CDIMP028", "criterio" => "Conoce los efectos en el control del equipo según distintos tipos de condiciones ambientales, sus efectos en el camino y las tecnicas de operación/conducción. "),
            array("competencia" => "CC032", "llave" => "CDIMP029", "criterio" => "Aplica técnica para la minimización de puntos ciegos en arranque y conducción."),
            array("competencia" => "CC015", "llave" => "CDIMP030", "criterio" => "Asegura el cierre de puertas, escotillas, ventanas  y portalón del vehículo."),
            array("competencia" => "CC051", "llave" => "CDIMP031", "criterio" => "Utilizar la caja de transmisión del vehículo o equipo, de acuerdo con recomendaciones del fabricante y condiciones del entorno."),
            array("competencia" => "CC050", "llave" => "CDIMP032", "criterio" => "Respeta la ruta de tránsito establecida de acuerdo con procedimientos e indicaciones de seguridad."),
            array("competencia" => "CC040", "llave" => "CDIMP033", "criterio" => "Asegura la carga o bulto a transportar de acuerdo al tipo y forma de esta, utilizando la sujeción adecuada cuando es necesario."),
            array("competencia" => "CC040", "llave" => "CDIMP034", "criterio" => "Asegura la estabilidad de la carga o bulto a transportar una vez ubicada en el sector definido."),
            array("competencia" => "CC017", "llave" => "CDIMP035", "criterio" => "Porta el sistema RECCO (solo Andina)"),
            array("competencia" => "CC017", "llave" => "CDIMP036", "criterio" => "Aplica el reglamento de operación de invierno de acuerdo a procedimiento (solo Andina)"),
            array("competencia" => "CC026", "llave" => "CDIMP037", "criterio" => "Aplica técnicas de conducción a la defensiva durante maniobras de giro, controlando velocidad y uso de transmisión."),
            array("competencia" => "CC030", "llave" => "CDIMP038", "criterio" => "Detiene el vehículo correctamente de acuerdo a procedimiento. Diminuye velocidad, situarse en lugar habilitado, activación luz intermitente y freno de mano, con motor encendido o apagado."),
            array("competencia" => "CC031", "llave" => "CDIMP039", "criterio" => "Aplica técnicas de conducción a la defensiva durante maniobras de retroceso según procedimiento. Verifica elementos del entorno y asegura la correcta visualización de los puntos ciegos."),
            array("competencia" => "CC021", "llave" => "CDIMP040", "criterio" => "Conoce y aplica técnicas de conducción a la defensiva adecuando el comportamiento de manejo según las condiciones climáticas adversas (vientos fuertes, nevazón, lluvia, etc.)"),
            array("competencia" => "CC025", "llave" => "CDIMP041", "criterio" => "Conoce, establece y respeta la distancia mínima de acercamiento de un vehículo en movimiento hacia un peatón."),
            array("competencia" => "CC029", "llave" => "CDIMP042", "criterio" => "Conoce y aplica técnicas de conducción a la defensiva durante una maniobra de adelantamiento de un vehículo y/o equipo, controlando la velocidad y el uso de la marcha adecuada."),
            array("competencia" => "CC033", "llave" => "CDIMP043", "criterio" => "Conoce, respetar la señalética vial, letreros, loros, semáforos, elementos de segregación, etc. Actua conforme a la información de la señalética vial."),
            array("competencia" => "CC038", "llave" => "CDIMP044", "criterio" => "Aplicar el reglamento de conducción interior mina (rajo, superficie, subterránea y camino industrial) cumpliendo con los requisitos definidos en el reglamento de conducción de la faena o específico del área de trabajoy considerando el uso adecuado del equipamiento necesario para transitar en el área donde se realiza la tarea y el conocimiento de las obligaciones, prohibiciones y sanciones establecidas."),
            array("competencia" => "CC041", "llave" => "CDIMP045", "criterio" => "Conoce y aplica el reglamento de perforación y tronadura. Conoce el horario y el lugar de la tronadura, respeta a los loros vivos y radios de tronadura. Conoce las sanciones  establecidas. "),
            array("competencia" => "CC052", "llave" => "CDIMP046", "criterio" => "Cumple con el procedimiento de cambio de neumáticos de vehículos livianos referente al torqueo de pernos o tuercas según periodicidad definida con un control trazable."),
            array("competencia" => "CC023", "llave" => "CDIMP047", "criterio" => "Detecta e identifica una falla en el vehículo durante la conducción. Las fallas pueden ser detectadas a través de la identificación de indicadores de advertencia en el panel del equipo, dispositivos de alarma, ruidos, vibraciones, humo, problemas en la dirección, en frenos y neumáticos, entre otros."),
            array("competencia" => "IMP044", "llave" => "CDIMP048", "criterio" => "Comunica al personal de camino y jefatura las contingencias o emergencia durante la conducción."),
            array("competencia" => "IMP045", "llave" => "CDIMP049", "criterio" => "Reporta el estado final de las contingencias y medidas de control de acuerdo a procedimiento."),
        );
        foreach ($datos as $criterio) {
            echo $criterio['llave'];
            $competencia = Competencia::where('llave', $criterio['competencia'])->get()->first();
            $newcriterio = new CriterioDesempeñoInterno();
            $newcriterio->competencia_id = $competencia->id;
            $newcriterio->llave = $criterio['llave'];
            $newcriterio->criterio = $criterio['criterio'];
            $newcriterio->save();
        }
    }
}
